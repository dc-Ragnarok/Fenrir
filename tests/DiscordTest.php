<?php

use Exan\Dhp\Discord;
use Exan\Dhp\EventHandler;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Mock;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class DiscordTest extends MockeryTestCase
{
    /**
     * @var callable
     */
    private $payloadHandler;

    private Discord $discord;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var Mock
         */
        $mockedLoop = Mockery::mock('React\EventLoop\LoopInterface');

        /**
         * @var Mock
         */
        $loopMock = Mockery::mock('overload:React\EventLoop\Loop');
        $loopMock->shouldReceive('get')->andReturn(
            $mockedLoop
        );

        /**
         * @var Mock
         */
        $connectorMock = Mockery::mock('overload:React\Socket\Connector');
        $connectorMock->shouldReceive('__construct')->andReturn(null);

        /**
         * @var Mock
         */
        $connectionMock = Mockery::mock(WebSocket::class);
        $connectionMock->shouldReceive('on')->andReturnUsing(function (string $event, callable $handler) {
            $this->payloadHandler = $handler;
        });

        /**
         * @var Mock
         */
        $promiseMock = Mockery::mock(Promise::class);
        $promiseMock->shouldReceive('then')->andReturnUsing(function (callable $callback, callable $error) use ($connectionMock) {
            $callback($connectionMock);
        });

        /**
         * @var Mock
         */
        $ratchetConnectorMock = Mockery::mock('overload:Ratchet\Client\Connector');
        $ratchetConnectorMock
            ->shouldReceive('__construct');

        $ratchetConnectorMock
            ->allows()->__invoke('wss://gateway.discord.gg/')->andReturns($promiseMock);

        $this->discord = new Discord('::token::');

        /**
         * @var Mock
         */
        $this->discord->events = Mockery::mock(EventHandler::class);
        $this->discord->events->shouldReceive('handle');

        $this->discord->connect();
    }

    private function mockIncomingMessage(array $message)
    {
        /**
         * @var Mock
         */
        $messageMock = Mockery::mock(MessageInterface::class);
        $messageMock->shouldReceive('__toString')->andReturn(json_encode($message));

        ($this->payloadHandler)($messageMock);
    }

    public function testRegularEventsGetForwardedToEventHandler()
    {
        $this->mockIncomingMessage(['op' => 0, 't' => '::some event::']);

        $this->discord->events->shouldHaveReceived('handle');
    }
}
