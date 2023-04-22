<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use Evenement\EventEmitter;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events as Events;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Events\Ready;
use Ragnarok\Fenrir\Websocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

class Connection
{
    public const DEFAULT_WEBSOCKET_URL = 'wss://gateway.discord.gg/?v=10';

    public EventHandler $events;

    public Websocket $websocket;

    private ?TimerInterface $heartbeatTimer;

    private ?int $sequence = null;

    private ?TimerInterface $scheduledReconnect;
    private string $sessionId;
    private string $reconnectUrl;

    private Puppet $puppet;

    public EventEmitter $raw;

    /**
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Gateway\Intents> $intents
     */
    public function __construct(
        private LoopInterface $loop,
        private string $token,
        private Bitwise $intents,
        private DataMapper $mapper,
        private LoggerInterface $logger = new NullLogger(),
        int $timeout = 10
    ) {
        $this->raw = new EventEmitter();
        $this->events = new EventHandler($this->mapper);

        $this->websocket = new Websocket($timeout, $this->logger);
        $this->puppet = new Puppet($this->websocket, $this->logger);

        $this->websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) {
            /** @var Payload */
            $payload = $this->mapper->map(json_decode((string) $message), Payload::class);

            $this->raw->emit($payload->op, [$payload]);
        });

        $this->setListeners();
    }

    private function setListeners(): void
    {
        $this->raw->on(0, function (Payload $payload) {
            if (isset($payload->s) && $payload->s > $this->sequence) {
                $this->sequence = $payload->s;
            }

            $this->events->handle($payload);
        });

        $this->raw->on(1, fn () => $this->puppet->sendHeartBeat($this->sequence));

        $this->raw->on(7, $this->reconnect(...));

        $this->raw->on(9, function (Payload $payload) {
            $recoverable = isset($payload->d) && $payload->d === true;
            if ($recoverable) {
                $this->reconnect();
                return;
            }

            $this->forceReconnect();
        });

        $this->raw->on(11, $this->cancelScheduledReconnect(...));
    }

    private function reconnect()
    {
        $this->logger->info('Gateway: attempting reconnect');

        if (isset($this->heartbeatTimer)) {
            $this->stopHeartbeat();
        }

        $this->puppet->terminate(1004, 'reconnecting');

        $this->puppet->connect($this->reconnectUrl)
            ->then(fn () => $this->raw->once(10, $this->resume(...)))
            ->otherwise(fn () => $this->forceReconnect());
    }

    private function forceReconnect()
    {
        $this->logger->info('Gateway: forcefully reconnecting');

        $this->sequence = null;

        unset($this->sessionId, $this->reconnectUrl);

        $this->puppet->connect(self::DEFAULT_WEBSOCKET_URL)
            ->then(fn () => $this->raw->once(10, $this->connect(...)))
            ->otherwise(fn () => function () {
                $this->logger->critical('Unable to connect to Discord');
            });
    }

    private function connect(Payload $payload)
    {
        $this->logger->info('Gateway: connecting');

        $this->startHeartbeat($payload->d->heartbeat_interval);
        $this->puppet->identify($this->token, $this->intents);

        $this->events->once(Events::READY, function (Ready $ready) {
            $this->sessionId = $ready->session_id;
            $this->reconnectUrl = $ready->resume_gateway_url;
        });
    }

    private function resume(Payload $payload)
    {
        $this->startHeartbeat($payload->d->heartbeat_interval);
        $this->puppet->resume($this->token, $this->sessionId, $this->sequence);
    }

    private function scheduleReconnect(): void
    {
        $this->scheduledReconnect = $this->loop->addTimer(0.5, function () {
            $this->reconnect();
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

    private function startHeartbeat(float $interval): void
    {
        $this->heartbeatTimer = $this->loop->addPeriodicTimer($interval / 1000, function () {
            $this->puppet->sendHeartBeat($this->sequence);
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

    public function open()
    {
        $this->raw->once(10, $this->connect(...));

        $this->puppet->connect(self::DEFAULT_WEBSOCKET_URL);
    }
}
