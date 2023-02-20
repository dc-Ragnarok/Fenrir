<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Discord;

use Exan\Finrir\Bitwise\Bitwise;
use Exan\Finrir\Const\WebsocketEvents;
use Exan\Finrir\Discord;
use Exan\Finrir\EventHandler;
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

        $bucketMock = Mockery::mock('overload:Exan\Finrir\Bucket');
        $bucketMock->shouldReceive('run')->andReturnUsing(fn ($fn) => $fn());

        $websocketMock = Mockery::mock('overload:Exan\Finrir\Websocket');
        $websocketMock->shouldReceive('on')->andReturnUsing(function (string $event, callable $handler) {
            $this->websocketHandlers[$event] = $handler;
        });
        $websocketMock->shouldReceive('open')->withAnyArgs()->andReturn(new Promise(function ($resolve) {
            $resolve();
        }));
        $websocketMock->shouldReceive('send')->withAnyArgs();
        $websocketMock->shouldReceive('close')->withAnyArgs();

        $this->discord = new Discord('::token::', new Bitwise(123), options: ['intents' => 123]);

        $this->discord->events = Mockery::mock(EventHandler::class);
        $this->discord->events->shouldReceive('handle');

        $this->discord->connect();

        $this->discord->websocket->shouldHaveReceived('open', [Discord::WEBSOCKET_URL]);
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

    protected function assertMessageSent(array $message, bool $useBucket = true)
    {
        $this->discord->websocket->shouldHaveReceived('send', [json_encode($message), $useBucket]);
    }

    protected function assertMessageNotSent(array $message, bool $useBucket = true)
    {
        $this->discord->websocket->shouldNotHaveReceived('send', [json_encode($message), $useBucket]);
    }
}
