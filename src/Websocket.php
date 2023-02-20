<?php

declare(strict_types=1);

namespace Exan\Finrir;

use Evenement\EventEmitter;
use Exan\Finrir\Const\WebsocketEvents;
use Exan\Finrir\Exceptions\Websocket\ConnectionNotInitializedException;
use Psr\Log\LoggerInterface;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket as RatchetWebsocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;
use React\Socket\Connector as SocketConnector;

class Websocket extends EventEmitter
{
    private Connector $connector;

    private RatchetWebsocket $connection;

    private LoopInterface $loop;
    private SocketConnector $socketConnector;

    private Bucket $bucket;

    public function __construct(private int $timeout, private LoggerInterface $logger)
    {
        $this->loop = Loop::get();
        $this->socketConnector = new SocketConnector(['timeout' => $timeout]);

        $this->connector = new Connector(
            $this->loop,
            $this->socketConnector
        );

        $this->bucket = new Bucket($this->loop, 110, 61);
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    private function mustHaveActiveConnection()
    {
        if (!isset($this->connection)) {
            throw new ConnectionNotInitializedException();
        }
    }

    public function open(string $url): Promise
    {
        return new Promise(function (callable $resolver, callable $reject) use ($url) {
            ($this->connector)($url)->then(function (RatchetWebsocket $connection) use ($resolver) {
                $this->connection = $connection;

                $connection->on('message', function (MessageInterface $message) {
                    $this->logger->info('WS(S->C): ' . $message);
                    $this->emit(WebsocketEvents::MESSAGE, [$message]);
                });

                $resolver();
            }, function (\Exception $e) use ($reject) {
                $reject($e);
            });
        });
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function close(int $code, string $reason)
    {
        $this->mustHaveActiveConnection();

        $this->connection->close($code, $reason);

        unset($this->connection);
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function send(string $message, bool $useBucket = true)
    {
        $this->mustHaveActiveConnection();

        $action = function () use ($message) {
            $this->connection->send($message);
            $this->logger->info('WS(C->S): ' . $message);
        };

        if ($useBucket) {
            $this->bucket->run($action);
        } else {
            $action();
        }
    }
}
