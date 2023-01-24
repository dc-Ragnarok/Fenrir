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

    private JsonMapper $jsonMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonMapper = new JsonMapper;
        $this->jsonMapper->bStrictNullTypes = false;
    }

    private function awaitResponse(EventHandler $eventHandler, string $event, Payload $payload): Promise
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
        $eventHandler = new EventHandler($this->jsonMapper, true);

        $payload = new Payload();
        $payload->t = '::event type::';

        $response = $this->awaitResponse($eventHandler, Events::RAW, $payload);

        $this->assertPromiseFulfillsWith($response, $payload);
    }

    public function testDoesNotEmitRawWhenSettingFalse(): void
    {
        $eventHandler = new EventHandler($this->jsonMapper, false);

        $payload = new Payload();
        $payload->t = '::event type::';

        $response = $this->awaitResponse($eventHandler, Events::RAW, $payload);

        $this->assertPromiseRejects($response, 1);
    }

    /**
     * @dataProvider eventProvider
     */
    public function testEmitEvent($event, $class): void
    {
        $eventHandler = new EventHandler($this->jsonMapper, false);

        $payload = new Payload();
        $payload->t = $event;
        $payload->d = new stdClass();

        $response = $this->awaitResponse(
            $eventHandler,
            $event,
            $payload
        );

        $this->assertPromiseFulfillsWithInstanceOf($response, $class);
    }

    public function eventProvider(): array
    {
        $array = [];

        foreach (Events::MAPPINGS as $event => $class) {
            $array[$event] = [
                'event' => $event,
                'class' => $class,
            ];
        }

        return $array;
    }
}
