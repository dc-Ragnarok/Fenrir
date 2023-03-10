<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir;

use Exan\Fenrir\Const\WebsocketEvents;
use Exan\Fenrir\Exceptions\Websocket\ConnectionNotInitializedException;
use Exan\Fenrir\Websocket;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;

use function Clue\React\Block\await;

class WebsocketTest extends TestCase
{
    public function testItThrowsAnErrorForActionsThatRequireConnection()
    {
        $websocket = new Websocket(10, new NullLogger());

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->close(123, '::reason::');

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->send('::message::');
    }

    public function testItConnectsToWsAndHasIOMessagesWithoutBucket()
    {
        $websocket = new Websocket(10, new NullLogger());

        await($websocket->open('ws://localhost:8080/echo'));

        $message = await(new Promise(function (callable $resolve) use ($websocket) {
            $websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) use ($resolve) {
                $resolve($message);
            });

            $websocket->send('::message::', false);
        }));

        $this->assertEquals('::message::', (string) $message);

        $websocket->close(1001, '::reason::');
    }

    public function testItConnectsToWsAndHasIOMessagesWithBucket()
    {
        $websocket = new Websocket(10, new NullLogger());

        await($websocket->open('ws://localhost:8080/echo'));

        $message = await(new Promise(function (callable $resolve) use ($websocket) {
            $websocket->on(WebsocketEvents::MESSAGE, function (MessageInterface $message) use ($resolve) {
                $resolve($message);
            });

            $websocket->send('::message::', true);
        }));

        $this->assertEquals('::message::', (string) $message);

        $websocket->close(1001, '::reason::');
    }
}
