<?php

namespace Exan\Dhp;

use Evenement\EventEmitter;
use Exan\Dhp\Const\WebsocketEvents;
use Exan\Dhp\Exceptions\Websocket\ConnectionNotInitializedException;
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

    public function __construct(private int $timeout)
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
        };

        if ($useBucket) {
            $this->bucket->run($action);
        } else {
            $action();
        }
    }
}
