<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\DataMapper;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use PHPUnit\Framework\TestCase;
use React\Promise\Promise;

final class EventHandlerTest extends TestCase
{
    private DataMapper $dataMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataMapper = DataMapperFake::get();
    }

    public function testDoesNotEmitIfUnknownEvent(): void
    {
        $eventHandler = new EventHandler($this->dataMapper, false);

        $payload = new Payload();
        $payload->t = '::unknown event::';

        $hasRun = false;
        $eventHandler->on('::unknown event::', function () use (&$hasRun) {
            $hasRun = true;
        });

        $eventHandler->handle($payload);

        $this->assertFalse($hasRun, 'Unknown event should not be emitted.');
    }

    /**
     * @dataProvider eventProvider
     */
    public function testEmitEvent($event, $class): void
    {
        $eventHandler = new EventHandler($this->dataMapper, false);

        $payload = new Payload();
        $payload->t = $event;
        $payload->d = (object) [];

        $hasRun = false;
        $eventHandler->on($event, function ($event) use (&$hasRun, $class) {
            $this->assertInstanceOf($class, $event);

            $hasRun = true;
        });

        $eventHandler->handle($payload);

        $this->assertTrue($hasRun, 'Known event should be emitted.');
    }

    public static function eventProvider(): array
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
