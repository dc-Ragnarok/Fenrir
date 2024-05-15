<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use Exan\Eventer\Eventer;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Handlers\HeartbeatAcknowledgedEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\InvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Handlers\Meta\UnacknowledgedHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Handlers\PassthroughEvent;
use Ragnarok\Fenrir\Gateway\Handlers\ReadyEvent;
use Ragnarok\Fenrir\Gateway\Handlers\ReconnectEvent;
use Ragnarok\Fenrir\Gateway\Handlers\RecoverableInvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Handlers\RequestHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Helpers\PresenceUpdateBuilder;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Ragnarok\Fenrir\Websocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\Promise\ExtendedPromiseInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Connection implements ConnectionInterface
{
    public const DEFAULT_WEBSOCKET_URL = 'wss://gateway.discord.gg/';
    private const QUERY_DATA = ['v' => 10];

    private const HEARTBEAT_ACK_TIMEOUT = 2.5;

    private ?int $sequence = null;

    private Websocket $websocket;

    private ?string $sessionId = null;
    private ?string $resumeUrl = null;

    public EventHandler $events;
    public Eventer $raw;
    public Eventer $meta;

    private TimerInterface $heartbeatTimer;
    private TimerInterface $unacknowledgedHeartbeatTimer;

    private ShardInterface $shard;

    public function __construct(
        private LoopInterface $loop,
        private string $token,
        private Bitwise $intents,
        private DataMapper $mapper,
        private LoggerInterface $logger = new NullLogger(),
        int $timeout = 10,
    ) {
        $this->websocket = new Websocket($timeout, $logger, [$this->token => '::token::']);
        $this->events = new EventHandler($mapper);

        $this->raw = new Eventer();
        $this->meta = new Eventer();

        $this->websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) {
            $parsedMessage = json_decode((string) $message, depth: 1024);
            if ($parsedMessage === null) {
                return;
            }

            $payload = $this->mapper->map($parsedMessage, Payload::class);

            $this->raw->emit((string) $payload->op, [$this, $payload, $this->logger]);
        });

        $this->registerEvents();
    }

    private function registerEvents(): void
    {
        $this->raw->register(
            HeartbeatAcknowledgedEvent::class,
            InvalidSessionEvent::class,
            PassthroughEvent::class,
            ReadyEvent::class,
            ReconnectEvent::class,
            RecoverableInvalidSessionEvent::class,
            RequestHeartbeatEvent::class
        );

        $this->raw->registerOnce(IdentifyHelloEvent::class);

        $this->meta->register(UnacknowledgedHeartbeatEvent::class);
    }

    public function getDefaultUrl(): string
    {
        return self::DEFAULT_WEBSOCKET_URL;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): void
    {
        $this->sequence = $sequence;
    }

    public function resetSequence(): void
    {
        $this->sequence = null;
    }

    public function connect(string $url): ExtendedPromiseInterface
    {
        $url .= '?' . http_build_query(self::QUERY_DATA);

        return $this->websocket->open($url);
    }

    public function disconnect(int $code, string $reason): void
    {
        $this->websocket->close($code, $reason);
    }

    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setResumeUrl(string $resumeUrl): void
    {
        $this->resumeUrl = $resumeUrl;
    }

    public function getResumeUrl(): ?string
    {
        return $this->resumeUrl;
    }

    public function sendHeartbeat(): void
    {
        $this->websocket->sendAsJson([
            'op' => 1,
            'd' => $this->sequence
        ], false);

        $this->expectHeartbeatAcknowledgement();
    }

    private function expectHeartbeatAcknowledgement(): void
    {
        $this->unacknowledgedHeartbeatTimer = $this->loop->addTimer(self::HEARTBEAT_ACK_TIMEOUT, function () {
            $this->meta->emit(MetaEvents::UNACKNOWLEDGED_HEARTBEAT, [$this, $this->logger]);
        });
    }

    public function acknowledgeHeartbeat(): void
    {
        $this->loop->cancelTimer($this->unacknowledgedHeartbeatTimer);
    }

    public function startAutomaticHeartbeats(int $ms): void
    {
        $this->heartbeatTimer = $this->loop->addPeriodicTimer($ms / 1000, $this->sendHeartbeat(...));
        $this->logger->debug('Started heartbeat timer', ['ms' => $ms]);
    }

    public function stopAutomaticHeartbeats(): void
    {
        $this->loop->cancelTimer($this->heartbeatTimer);
        $this->logger->debug('Cancelled heartbeat timer');
    }

    public function getEventHandler(): EventHandler
    {
        return $this->events;
    }

    public function getRawHandler(): Eventer
    {
        return $this->raw;
    }

    public function getMetaHandler(): Eventer
    {
        return $this->meta;
    }

    public function identify(): void
    {
        $payload = [
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
        ];

        if (isset($this->shard)) {
            $payload['d']['shard'] = $this->shard->getShardSettings();
        }

        $this->websocket->sendAsJson($payload, true);
    }

    public function resume(): void
    {
        $this->websocket->sendAsJson([
            'op' => 6,
            'd' => [
                'token' => $this->token,
                'session_id' => $this->sessionId,
                'seq' => $this->sequence,
            ]
        ], true);
    }

    public function open(): ExtendedPromiseInterface
    {
        return $this->connect(self::DEFAULT_WEBSOCKET_URL);
    }

    public function shard(ShardInterface $shard)
    {
        $this->shard = $shard;
    }

    public function updatePresence(PresenceUpdateBuilder $presenceUpdate): void
    {
        $this->websocket->sendAsJson([
            'op' => 3,
            'd' => $presenceUpdate->get(),
        ], true);
    }
}
