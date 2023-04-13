<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events as Events;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\Enums\Gateway\StatusType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Ragnarok\Fenrir\Gateway\Objects\D\Hello;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Exceptions\Retrier\TooManyRetriesException;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\Promise\ExtendedPromiseInterface;

class Gateway
{
    public const WEBSOCKET_URL = 'wss://gateway.discord.gg/?v=10';
    private const MAX_RECONNECT_ATTEMPTS = 3;

    public EventHandler $events;

    public Websocket $websocket;

    private ?float $heartbeatInterval;
    private ?TimerInterface $heartbeatTimer;

    private ?int $sequence = null;

    private ?TimerInterface $scheduledReconnect;
    private string $sessionId;
    private string $reconnectUrl;

    private bool $shouldIdentify = true;

    private Bucket $activityBucket;

    /**
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Gateway\Intents> $intents
     */
    public function __construct(
        private LoopInterface $loop,
        private string $token,
        private Bitwise $intents,
        private DataMapper $mapper,
        private LoggerInterface $logger = new NullLogger(),
        int $timeout = 10,
        bool $rawEvents = false
    ) {
        $this->events = new EventHandler($this->mapper, $rawEvents);

        $this->websocket = new Websocket($timeout, $this->logger);

        $this->websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) {
            /** @var Payload */
            $payload = $this->mapper->map(json_decode((string) $message), Payload::class);

            $this->handlePayload($payload);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function connect(): ExtendedPromiseInterface
    {
        return Retrier::retryAsync(self::MAX_RECONNECT_ATTEMPTS, function (int $attempt) {
            $this->logger->info(
                sprintf('Attempt #%d connecting to %s', $attempt, self::WEBSOCKET_URL)
            );

            return $this->websocket->open(self::WEBSOCKET_URL);
        })->otherwise(function (TooManyRetriesException $e) {
            $this->logger->emergency('Unable to connect to Discord.');
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function reconnect(bool $close, bool $resume): void
    {
        $this->logger->info('Gateway: attempting reconnect');

        if (isset($this->heartbeatTimer)) {
            $this->stopHeartbeat();
        }

        if ($close) {
            $this->websocket->close(1001, 'reconnecting');
        }

        $this->shouldIdentify = !$resume;

        Retrier::retryAsync(self::MAX_RECONNECT_ATTEMPTS, function (int $attempt) {
            $this->logger->info(
                sprintf('Attempt #%d connecting to %s', $attempt, self::WEBSOCKET_URL)
            );

            return $this->websocket->open($this->reconnectUrl);
        })->otherwise(function (TooManyRetriesException $e) {
            $this->logger->error('Failed reconnecting to Discord. Resetting and creating new connection instead.');

            $this->reset();
            $this->connect();
        });
    }

    private function reset(): void
    {
        $this->shouldIdentify = true;
        $this->sequence = null;

        unset(
            $this->websocket,
            $this->heartbeatInterval,
            $this->heartbeatTimer,
            $this->scheduledReconnect,
            $this->sessionId,
            $this->reconnectUrl
        );
    }

    private function resume(): void
    {
        $this->sendPayload([
            'op' => 6,
            'd' => [
                'token' => $this->token,
                'session_id' => $this->sessionId,
                'seq' => $this->sequence,
            ]
        ]);
    }

    private function scheduleReconnect(): void
    {
        $this->scheduledReconnect = $this->loop->addTimer(5, function () {
            $this->reconnect(true, true);
        });

        $this->logger->info('Gateway: Scheduled reconnect');
    }

    private function cancelScheduledReconnect(): void
    {
        if (!isset($this->scheduledReconnect)) {
            return;
        }

        $this->loop->cancelTimer($this->scheduledReconnect);

        $this->scheduledReconnect = null;

        $this->logger->info('Gateway: Cancelled scheduled reconnect');
    }

    private function identify(): void
    {
        $this->sendPayload([
            'op' => 2,
            'd' => [
                'token' => $this->token,
                'intents' => $this->intents->get(),
                'properties' => [
                    'os' => PHP_OS,
                    'browser' => 'Ragnarok\Fenrir',
                    'device' => 'Ragnarok\Fenrir',
                ]
            ]
        ]);

        $this->shouldIdentify = false;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function handlePayload(Payload $payload): void
    {
        switch ($payload->op) {
            /**
             * "Regular" events
             */
            case 0:
                if (isset($payload->s) && $payload->s > $this->sequence) {
                    $this->sequence = $payload->s;
                }

                $this->handleEvent($payload);
                break;

            /**
             * Resume event
             */
            case 7:
                $this->reconnect(true, true);
                break;

            /**
             * Invalid session
             */
            case 9:
                $this->reconnect(
                    false,
                    isset($payload->d) && $payload->d === true
                );
                break;

            /**
             * Hello event
             */
            case 10:
                /** @var Hello */
                $hello = $this->mapper->map($payload->d, Hello::class);
                $this->handleHello($hello);

                if ($this->shouldIdentify) {
                    $this->identify();
                    return;
                }

                $this->resume();

                break;

            /**
             * Acknowledgement of heartbeat
             */
            case 11:
                $this->cancelScheduledReconnect();
                break;
        }
    }

    private function handleHello(Hello $data): void
    {
        $this->heartbeatInterval = $data->heartbeat_interval;

        $this->startHeartbeat();
    }

    private function handleEvent(Payload $payload): void
    {
        if ($payload->t === Events::READY && isset($payload->d->session_id, $payload->d->resume_gateway_url)) {
            $this->sessionId = $payload->d->session_id;
            $this->reconnectUrl = $payload->d->resume_gateway_url;
        }

        $this->events->handle($payload);
    }

    private function sendPayload(array $data, bool $useBucket = true): void
    {
        $this->websocket->send(json_encode($data), $useBucket);
    }

    private function startHeartbeat(): void
    {
        $this->heartbeatTimer = $this->loop->addPeriodicTimer($this->heartbeatInterval / 1000, function () {
            $this->sendPayload([
                'op' => 1,
                'd' => $this->sequence
            ], false);

            $this->scheduleReconnect();
        });

        $this->logger->info('Gateway: Started heartbeats');
    }

    private function stopHeartbeat(): void
    {
        if ($this->heartbeatTimer) {
            $this->loop->cancelTimer($this->heartbeatTimer);

            unset($this->heartbeatTimer);
        }

        $this->logger->info('Gateway: Stopped heartbeats');
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#update-presence
     */
    public function updatePresence(
        StatusType $status,
        array $activities,
        bool $afk = false,
        ?int $since = null
    ): void {
        if (!isset($this->activityBucket)) {
            $this->activityBucket = new Bucket($this->loop, 5, 21);
        }

        $this->activityBucket->run(function () use ($status, $activities, $afk, $since) {
            $presenceUpdate = [
                'status' => $status->value,
                'activities' => array_map(fn (ActivityBuilder $builder) => $builder->get(), $activities),
                'afk' => $afk,
            ];

            if (!is_null($since)) {
                $presenceUpdate['since'] = $since;
            }

            $this->sendPayload($presenceUpdate);
        });
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#request-guild-members
     */
    public function requestGuildMembersByQuery(
        string $guildId,
        string $query = '',
        int $limit = 0,
        bool $presences = false,
        ?string $nonce = null
    ): void {
        $guildMemberRequest = [
            'guild_id' => $guildId,
            'query' => $query,
            'limit' => $limit,
            'presences' => $presences,
        ];

        if (!is_null($nonce)) {
            $guildMemberRequest['nonce'] = $nonce;
        }

        $this->sendPayload($guildMemberRequest);
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#request-guild-members
     */
    public function requestGuildMembersByUserIds(
        string $guildId,
        array $userIds,
        int $limit = 0,
        bool $presences = false,
        ?string $nonce = null
    ): void {
        $guildMemberRequest = [
            'guild_id' => $guildId,
            'user_ids' => $userIds,
            'limit' => $limit,
            'presences' => $presences,
        ];

        if (!is_null($nonce)) {
            $guildMemberRequest['nonce'] = $nonce;
        }

        $this->sendPayload($guildMemberRequest);
    }
}
