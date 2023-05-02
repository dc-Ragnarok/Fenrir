<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\DataMapper;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use React\Promise\Promise;
use seregazhuk\React\PromiseTesting\AssertsPromise;
use stdClass;

final class EventHandlerTest extends TestCase
{
    use AssertsPromise;

    private DataMapper $dataMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataMapper = DataMapperFake::get();
    }

    private function awaitResponse(EventHandler $eventHandler, string $event, Payload $payload): Promise
    {
        return new Promise(static function ($resolve) use ($eventHandler, $event, $payload) {
            $eventHandler->on($event, static function (mixed $eventResponse) use ($resolve) {
                $resolve($eventResponse);
            });

            $eventHandler->handle($payload);
        });
    }

    public function testDoesNotEmitIfUnknownEvent(): void
    {
        $eventHandler = new EventHandler($this->dataMapper, false);

        $payload = new Payload();
        $payload->t = '::unknown event::';

        $response = $this->awaitResponse($eventHandler, '::unknown event::', $payload);

        $this->assertPromiseRejects($response, 1);
    }

    /**
     * @dataProvider eventProvider
     */
    public function testEmitEvent($event, $class): void
    {
        $eventHandler = new EventHandler($this->dataMapper, false);

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
            $array[$event] = compact('event', 'class');
        }

        return $array;
    }
}
