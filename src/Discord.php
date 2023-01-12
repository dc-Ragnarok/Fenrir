<?php

namespace Exan\Dhp;

use Exan\Dhp\Const\Events as Events;
use Exan\Dhp\Websocket\Objects\D\Hello;
use Exan\Dhp\Websocket\Objects\Payload;
use JsonMapper;
use Ratchet\Client\Connector as RatchetConnector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\Socket\Connector;

class Discord
{
    public EventHandler $events;

    private const WEBSOCKET_URL = 'wss://gateway.discord.gg/';
    private LoopInterface $loop;

    private Connector $connector;
    private WebSocket $connection;

    private JsonMapper $mapper;

    private ?float $heartbeatInterval;
    private ?TimerInterface $heartbeatTimer;

    private ?int $sequence = null;

    private int $intents;

    private ?TimerInterface $scheduledReconnect;
    private string $sessionId;
    private string $reconnectUrl;

    private RatchetConnector $ratchetConnector;

    private bool $shouldIdentify = true;

    public function __construct(private string $token, $options = [])
    {
        $options = array_merge([
            'timeout' => 10,
            'raw_events' => false,
            'intents' => 3243773
        ], $options);

        $this->intents = $options['intents'];

        $this->events = new EventHandler($options['raw_events']);

        $this->mapper = new JsonMapper();

        $this->loop = Loop::get();
        $this->connector = new Connector(['timeout' => $options['timeout']]);
    }

    public function connect()
    {
        $this->ratchetConnector = new RatchetConnector(
            $this->loop,
            $this->connector
        );

        /**
         * Weird syntax required for Mockery in testing
         */
        $this->ratchetConnector->{'__invoke'}(self::WEBSOCKET_URL)->then(function (WebSocket $connection) {
            $this->handleNewConnection($connection);

        }, function (\Exception $e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }

    private function reconnect(bool $close, bool $resume)
    {
        if ($close) {
            $this->connection->close(1001, 'reconnecting');
        }

        $this->shouldIdentify = !$resume;

        $this->ratchetConnector->{'__invoke'}($this->reconnectUrl)->then(function (WebSocket $connection) use ($resume) {
            $this->handleNewConnection($connection);
        }, function (\Exception $e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }

    private function handleNewConnection(WebSocket $connection)
    {
        $this->connection = $connection;

        $connection->on('message', function (MessageInterface $message) {
            $payload = $this->mapper->map(json_decode((string) $message), new Payload());

            $this->handlePayload($payload);
        });
    }

    private function resume()
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

    private function scheduleReconnect()
    {
        $this->scheduledReconnect = $this->loop->addTimer(5, function () {
            $this->reconnect(true, true);
        });
    }

    private function cancelScheduledReconnect()
    {
        if (!isset($this->scheduledReconnect)) {
            return;
        }

        $this->loop->cancelTimer($this->scheduledReconnect);

        $this->scheduledReconnect = null;
    }

    private function identify()
    {
        $this->sendPayload([
            'op' => 2,
            'd' => [
                'token' => $this->token,
                'intents' => $this->intents,
                'properties' => [
                    'os' => PHP_OS,
                    'browser' => 'Exan\DHP',
                    'device' => 'Exan\DHP',
                ]
            ]
        ]);

        $this->shouldIdentify = false;
    }

    private function handlePayload(Payload $payload)
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
                if ($this->shouldIdentify) {
                    $this->identify();
                } else {
                    $this->resume();
                }

                $this->handleHello($this->mapper->map($payload->d, new Hello()));
                break;

            /**
             * Acknowledgement of heartbeat
             */
            case 11:
                $this->cancelScheduledReconnect();
                break;
        }
    }

    private function handleHello(Hello $data)
    {
        $this->heartbeatInterval = $data->heartbeat_interval;

        $this->heartbeatTimer = $this->loop->addPeriodicTimer($this->heartbeatInterval / 1000, function () {
            $this->sendPayload([
                'op' => 1,
                'd' => $this->sequence
            ]);

            $this->scheduleReconnect();
        });
    }

    private function handleEvent(Payload $payload)
    {
        if ($payload->t === Events::READY && isset($payload->d->session_id, $payload->d->resume_gateway_url)) {
            $this->sessionId = $payload->d->session_id;
            $this->reconnectUrl = $payload->d->resume_gateway_url;
        }

        $this->events->handle($payload);
    }

    private function sendPayload(array $data)
    {
        $this->connection->send(json_encode($data));
    }
}
