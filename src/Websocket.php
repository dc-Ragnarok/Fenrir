<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Evenement\EventEmitter;
use JsonSerializable;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Buffer\BufferInterface;
use Ragnarok\Fenrir\Buffer\Passthrough;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\Exceptions\Websocket\ConnectionFailedException;
use Ragnarok\Fenrir\Exceptions\Websocket\ConnectionNotInitializedException;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket as RatchetWebsocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\Promise\Promise;
use React\Socket\Connector as SocketConnector;

class Websocket extends EventEmitter implements WebsocketInterface
{
    private Connector $connector;

    private RatchetWebsocket $connection;

    private LoopInterface $loop;
    private SocketConnector $socketConnector;

    private Bucket $bucket;

    public function __construct(
        private int $timeout,
        private LoggerInterface $logger,
        private array $sendLoggerBlacklist = [],
        private readonly BufferInterface $buffer = new Passthrough(),
    ) {
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

    public function open(string $url): PromiseInterface
    {
        $this->logger->debug('Client: Attempting connection', ['url' => $url]);

        return new Promise(function (callable $resolver, callable $reject) use ($url) {
            ($this->connector)($url)->then(function (RatchetWebsocket $connection) use ($url, $resolver) {
                $this->connection = $connection;

                $this->logger->info('Client: Connection esablished', ['url' => $url]);

                $this->buffer->onCompleteMessage(function (string $message) {
                    $this->logger->debug('Server: New message', ['message' => $message]);
                    $this->emit(WebsocketEvents::MESSAGE, [$message]);
                });

                $connection->on('message', function (MessageInterface $message) {
                    $this->buffer->partialMessage((string) $message);
                });

                $connection->on('close', function (int $code, string $reason = '') {
                    $this->logger->debug('Connection closed', ['code' => $code, 'reason' => $reason]);
                    $this->emit(WebsocketEvents::CLOSE, [$code, $reason]);
                });

                $resolver(null);
            }, function (\Exception $e) use ($url, $reject) {
                $this->logger->error(
                    'Client: Error connecting to server',
                    ['url' => $url, 'error' => $e->getMessage()]
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
            'Client: Closing connection',
            ['code' => $code, 'reason' => $reason]
        );

        $this->connection->close($code, $reason);
        $this->buffer->reset();

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
            $this->logger->debug('Client: New message', [$this->filterSentMessage($message)]);
        };

        if ($useBucket) {
            $this->logger->debug('Client: Queued message', [$this->filterSentMessage($message)]);

            $this->bucket->run($action);

            return;
        }

        $action();
    }

    private function filterSentMessage(string $message)
    {
        return str_replace(array_keys($this->sendLoggerBlacklist), array_values($this->sendLoggerBlacklist), $message);
    }

    /**
     * @throws ConnectionNotInitializedException
     */
    public function sendAsJson(array|JsonSerializable $item, bool $useBucket): void
    {
        $this->send(json_encode($item), $useBucket);
    }

    public function getBuffer(): BufferInterface
    {
        return $this->buffer;
    }
}
