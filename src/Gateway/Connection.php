<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use Exan\Eventer\Eventer;
use Exan\Retrier\Retrier;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\GatewayCloseCodes;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Events\Meta\MetaEvent;
use Ragnarok\Fenrir\Gateway\Handlers\HeartbeatAcknowledgedEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyResumeEvent;
use Ragnarok\Fenrir\Gateway\Handlers\InvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Handlers\Meta\UnacknowledgedHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Handlers\PassthroughEvent;
use Ragnarok\Fenrir\Gateway\Handlers\ReadyEvent;
use Ragnarok\Fenrir\Gateway\Handlers\ReconnectEvent;
use Ragnarok\Fenrir\Gateway\Handlers\RecoverableInvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Handlers\RequestHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Helpers\PresenceUpdateBuilder;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Ragnarok\Fenrir\WebsocketInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\Promise\PromiseInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Connection implements ConnectionInterface
{
    public const DISCORD_VERSION = 10;
    public const DEFAULT_WEBSOCKET_URL = 'wss://gateway.discord.gg/';

    private const QUERY_DATA = ['v' => self::DISCORD_VERSION];

    private const HEARTBEAT_ACK_TIMEOUT = 2.5;

    private ?int $sequence = null;

    private ?string $sessionId = null;
    private ?string $resumeUrl = null;

    public EventHandler $events;

    private TimerInterface $heartbeatTimer;
    private TimerInterface $unacknowledgedHeartbeatTimer;

    private ShardInterface $shard;

    public function __construct(
        private LoopInterface $loop,
        private string $token,
        private Bitwise $intents,
        private DataMapper $mapper,
        private WebsocketInterface $websocket,
        private LoggerInterface $logger = new NullLogger(),
        private Eventer $raw = new Eventer(),
        private Eventer $meta = new Eventer(),
        private Retrier $retrier = new Retrier(),
    ) {
        $this->events = new EventHandler($mapper);

        $this->websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) {
            $parsedMessage = json_decode((string) $message, depth: 1024);
            if ($parsedMessage === null) {
                return;
            }

            $payload = $this->mapper->map($parsedMessage, Payload::class);

            $this->raw->emit((string) $payload->op, [$this, $payload, $this->logger]);
        });

        $this->websocket->on(WebsocketEvents::CLOSE, $this->handleClose(...));

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

    private function handleClose(int $code, string $reason): void
    {
        $this->meta->emit(MetaEvents::DISCONNECT, [$this, $this->logger]);

        $this->stopAutomaticHeartbeats();

        $description = GatewayCloseCodes::DESCRIPTIONS[$code] ?? sprintf('Unknown error code %d - %s', $code, $reason);
        $isUserError = GatewayCloseCodes::USER_ERROR[$code] ?? false;
        $isRecoverable = GatewayCloseCodes::RECOVERABLE[$code] ?? false;
        $isResumable = GatewayCloseCodes::RECOVERABLE[$code] ?? false;

        $message = $description . ' '
            . (
                $isUserError
                ? 'This is likely a userspace error.'
                : 'This is likely caused by Discord or the library. If you suspect the latter, please report it on Github.'
            );

        $context = ['code' => $code, 'reason' => $reason];

        if (!$isRecoverable) {
            $this->logger->emergency($message, $context);

            $this->loop->stop();
            return;
        }

        $this->logger->error($message, $context);

        if ($isResumable && $this->meetsResumeRequirements()) {
            $this->resumeConnection();
            return;
        }

        $this->sequence = null;
        $this->startNewConnection();
    }

    private function resumeConnection(): void
    {
        $this->retrier->retry(3, function ($i) {
            $this->logger->info(sprintf('Reconnecting and resuming session, attempt %d.', $i));

            return $this->connect($this->resumeUrl)->then(function () {
                $this->raw->registerOnce(IdentifyResumeEvent::class);
            });
        });
    }

    private function startNewConnection(): void
    {
        $this->retrier->retry(3, function ($i) {
            $this->logger->info(sprintf('Forceful reconnection attempt %d.', $i));

            return $this->open()->then(function () {
                $this->raw->registerOnce(IdentifyHelloEvent::class);
            });
        });
    }

    public function meetsResumeRequirements(): bool
    {
        return !(is_null($this->resumeUrl) || is_null($this->sessionId));
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

    public function connect(string $url): PromiseInterface
    {
        $url .= '?' . http_build_query(self::QUERY_DATA);

        return $this->websocket->open($url);
    }

    public function disconnect(int $code, string $reason): void
    {
        $this->cancelHeartbeatAcknowledgement();

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
        $this->cancelHeartbeatAcknowledgement();
    }

    private function cancelHeartbeatAcknowledgement(): void
    {
        if (isset($this->unacknowledgedHeartbeatTimer)) {
            $this->loop->cancelTimer($this->unacknowledgedHeartbeatTimer);
        }
    }

    public function startAutomaticHeartbeats(int $ms): void
    {
        $this->heartbeatTimer = $this->loop->addPeriodicTimer($ms / 1000, $this->sendHeartbeat(...));
        $this->logger->debug('Started heartbeat timer', ['ms' => $ms]);
    }

    private function stopAutomaticHeartbeats(): void
    {
        if (isset($this->heartbeatTimer)) {
            $this->loop->cancelTimer($this->heartbeatTimer);
            $this->logger->debug('Cancelled heartbeat timer');
        }
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

    public function open(): PromiseInterface
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
