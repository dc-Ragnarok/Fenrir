<?php

namespace Tests\Exan\Dhp\Discord;

use Exan\Dhp\Const\WebsocketEvents;
use Exan\Dhp\Discord;
use Exan\Dhp\EventHandler;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Mock;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;

class DiscordTestCase extends MockeryTestCase
{
    /**
     * @var Mock
     */
    protected $loop;

    /**
     * @var Mock
     */
    protected $websocket;

    protected Discord $discord;

    protected array $websocketHandlers = [];

    protected function setUp(): void
    {
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

        $websocketMock = Mockery::mock('overload:Exan\Dhp\Websocket');
        $websocketMock->shouldReceive('on')->andReturnUsing(function (string $event, callable $handler) {
            $this->websocketHandlers[$event] = $handler;
        });
        $websocketMock->shouldReceive('open')->withAnyArgs()->andReturn(new Promise(function ($resolve) { $resolve(); }));
        $websocketMock->shouldReceive('send')->withAnyArgs();
        $websocketMock->shouldReceive('close')->withAnyArgs();

        $this->discord = new Discord('::token::', ['intents' => 123]);

        $this->discord->events = Mockery::mock(EventHandler::class);
        $this->discord->events->shouldReceive('handle');

        $this->discord->connect();

        $this->discord->websocket->shouldHaveReceived('open', ['wss://gateway.discord.gg/']);
    }

    protected function mockIncomingMessage(array $message)
    {
        /**
         * @var Mock
         */
        $messageMock = Mockery::mock(MessageInterface::class);
        $messageMock->shouldReceive('__toString')->andReturn(json_encode($message));

        ($this->websocketHandlers[WebsocketEvents::MESSAGE])($messageMock);
    }

    protected function assertMessageSent(array $message)
    {
        $this->discord->websocket->shouldHaveReceived('send', [json_encode($message)]);
    }

    protected function assertMessageNotSent(array $message)
    {
        $this->discord->websocket->shouldNotHaveReceived('send', [json_encode($message)]);
    }
}
