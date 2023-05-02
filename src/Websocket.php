<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Evenement\EventEmitter;
use Exception;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\Exceptions\Websocket\ConnectionNotInitializedException;
use JsonSerializable;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Exceptions\Websocket\ConnectionFailedException;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket as RatchetWebsocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\ExtendedPromiseInterface;
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
    private function mustHaveActiveConnection(): void
    {
        if (!isset($this->connection)) {
            throw new ConnectionNotInitializedException();
        }
    }

    public function open(string $url): ExtendedPromiseInterface
    {
        $this->logger->info(
            sprintf('WS (C->S): Connecting to %s', $url)
        );

        return new Promise(function (callable $resolver, callable $reject) use ($url) {
            ($this->connector)($url)->then(function (RatchetWebsocket $connection) use ($url, $resolver) {
                $this->connection = $connection;

                $this->logger->info(
                    sprintf('WS (C->S): Connected to %s', $url)
                );

                $connection->on('message', function (MessageInterface $message) {
                    $this->logger->info('WS(S->C): ' . $message);
                    $this->emit(WebsocketEvents::MESSAGE, [$message]);
                });

                $resolver();
            }, function (Exception $e) use ($url, $reject) {
                $this->logger->info(
                    sprintf('WS (C->S): Error connecting to %s. %s', $url, $e->getMessage())
                );

                $reject(new ConnectionFailedException(previous: $e));
            });
        });
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function close(int $code, string $reason): void
    {
        $this->mustHaveActiveConnection();

        $this->logger->info(
            sprintf('WS (C->S): Closing connection: code = %d, reason = $s', $code, $reason)
        );

        $this->connection->close($code, $reason);

        unset($this->connection);
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function send(string $message, bool $useBucket = true): void
    {
        $this->mustHaveActiveConnection();

        $action = function () use ($message) {
            $this->connection->send($message);
            $this->logger->info(
                sprintf('WS(C->S): %s', $message)
            );
        };

        if ($useBucket) {
            $this->logger->info(
                sprintf('WS(C->S): (queued) %s', $message)
            );

            $this->bucket->run($action);

            return;
        }

        $action();
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function sendAsJson(array|JsonSerializable $item, bool $useBucket): void
    {
        $this->send(json_encode($item), $useBucket);
    }
}
