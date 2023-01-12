<?php

namespace Tests\Exan\Dhp\Discord;

use Exan\Dhp\Discord;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Mock;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;

class DiscordTestCase extends MockeryTestCase
{
    /**
     * @var callable
     */
    protected $payloadHandler;

    /**
     * @var Mock
     */
    protected $connection;

    /**
     * @var Mock
     */
    protected $loop;

    /**
     * @var Mock
     */
    protected $ratchetConnectorMock;

    protected Discord $discord;

    protected $ratchetConnectorMockOptions;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var Mock
         */
        $this->loop = Mockery::mock('React\EventLoop\LoopInterface');

        /**
         * @var Mock
         */
        $loopMock = Mockery::mock('overload:React\EventLoop\Loop');
        $loopMock->shouldReceive('get')->andReturn(
            $this->loop
        );

        /**
         * @var Mock
         */
        $connectorMock = Mockery::mock('overload:React\Socket\Connector');
        $connectorMock->shouldReceive('__construct')->andReturn(null);

        /**
         * @var Mock
         */
        $this->connection = Mockery::mock(WebSocket::class);
        $this->connection->shouldReceive('on')->andReturnUsing(function (string $event, callable $handler) {
            $this->payloadHandler = $handler;
        });
        $this->connection->shouldReceive('send');


        /**
         * @var Mock
         */
        $promiseMock = Mockery::mock(Promise::class);
        $promiseMock->shouldReceive('then')->andReturnUsing(function (callable $callback, callable $error) {
            $callback($this->connection);
        });

        $this->ratchetConnectorMockOptions['wss://gateway.discord.gg/'] = $promiseMock;

        /**
         * @var Mock
         */
        $this->ratchetConnectorMock = Mockery::mock('overload:Ratchet\Client\Connector');
        $this->ratchetConnectorMock
            ->shouldReceive('__construct');

        $this->ratchetConnectorMock
            ->shouldReceive('__invoke')->andReturnUsing(function ($input) {
                if (isset($this->ratchetConnectorMockOptions[$input])) {
                    return $this->ratchetConnectorMockOptions[$input];
                }
            });

        $this->discord = new Discord('::token::', ['intents' => 123]);

        $this->discord->connect();
    }

    protected function mockIncomingMessage(array $message)
    {
        /**
         * @var Mock
         */
        $messageMock = Mockery::mock(MessageInterface::class);
        $messageMock->shouldReceive('__toString')->andReturn(json_encode($message));

        ($this->payloadHandler)($messageMock);
    }

    protected function assertMessageSent(array $message)
    {
        $this->connection->shouldHaveReceived('send', [json_encode($message)]);
    }
}
