<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\Exceptions\Websocket\ConnectionNotInitializedException;
use Ragnarok\Fenrir\Websocket;
use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;

use function Clue\React\Block\await;

class WebsocketTest extends TestCase
{
    public function testItThrowsAnErrorForActionsThatRequireConnection(): void
    {
        $websocket = new Websocket(10, new NullLogger());

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->close(123, '::reason::');

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->send('::message::');
    }

    public function testItConnectsToWsAndHasIOMessagesWithoutBucket(): void
    {
        $websocket = new Websocket(10, new NullLogger());

        await($websocket->open('ws://localhost:8080/echo'));

        $message = await(new Promise(static function (callable $resolve) use ($websocket) {
            $websocket->on(WebsocketEvents::MESSAGE, static function (MessageInterface $message) use ($resolve) {
                $resolve($message);
            });

            $websocket->send('::message::', false);
        }));

        $this->assertEquals('::message::', (string) $message);

        $websocket->close(1001, '::reason::');
    }

    public function testItConnectsToWsAndHasIOMessagesWithBucket(): void
    {
        $websocket = new Websocket(10, new NullLogger());

        await($websocket->open('ws://localhost:8080/echo'));

        $message = await(new Promise(static function (callable $resolve) use ($websocket) {
            $websocket->on(WebsocketEvents::MESSAGE, static function (MessageInterface $message) use ($resolve) {
                $resolve($message);
            });

            $websocket->send('::message::', true);
        }));

        $this->assertEquals('::message::', (string) $message);

        $websocket->close(1001, '::reason::');
    }

    public function testItCanSendJsonSerializableItems(): void
    {
        $websocket = new Websocket(10, new NullLogger());

        await($websocket->open('ws://localhost:8080/echo'));

        $jsonItem = new class implements JsonSerializable {
            public function jsonSerialize(): array
            {
                return ['hello' => 'world'];
            }
        };

        $message = await(new Promise(static function (callable $resolve) use ($websocket, $jsonItem) {
            $websocket->on(WebsocketEvents::MESSAGE, static function (MessageInterface $message) use ($resolve) {
                $resolve($message);
            });

            $websocket->sendAsJson($jsonItem, true);
        }));

        $this->assertEquals('{"hello":"world"}', (string) $message);

        $websocket->close(1001, '::reason::');
    }
}
