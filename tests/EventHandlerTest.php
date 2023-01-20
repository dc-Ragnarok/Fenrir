<?php

declare(strict_types=1);

use Exan\Dhp\Const\Events;
use Exan\Dhp\EventHandler;
use Exan\Dhp\Websocket\Objects\Payload;
use PHPUnit\Framework\TestCase;
use React\Promise\Promise;
use seregazhuk\React\PromiseTesting\AssertsPromise;

final class EventHandlerTest extends TestCase
{
    use AssertsPromise;

    private function awaitResponse(EventHandler $eventHandler, string $event, Payload $payload): mixed
    {
        return new Promise(function ($resolve) use ($eventHandler, $event, $payload) {
            $eventHandler->on($event, function (mixed $eventResponse) use ($resolve) {
                $resolve($eventResponse);
            });

            $eventHandler->handle($payload);
        });
    }

    public function testEmitRaw(): void
    {
        $eventHandler = new EventHandler(true);

        $payload = new Payload();
        $payload->t = '::event type::';

        $response = $this->awaitResponse($eventHandler, Events::RAW, $payload);

        $this->assertPromiseFulfillsWith($response, $payload);
    }
}
