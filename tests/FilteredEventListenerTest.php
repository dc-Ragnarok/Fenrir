<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir;

use Evenement\EventEmitter;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\EventHandler;
use Exan\Fenrir\FilteredEventEmitter;
use Exan\Fenrir\Websocket\Objects\Payload;
use Fakes\Exan\Fenrir\DataMapperFake;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class FilteredEventListenerTest extends MockeryTestCase
{
    public function testFilteringEvents()
    {

        $eventEmitter = new EventEmitter();

        $filteredEmitter = new FilteredEventEmitter(
            $eventEmitter,
            'event',
            fn (int $input) => $input === 10
        );

        $container = [];
        $filteredEmitter->on('event', function (int $input) use (&$container) {
            $container[] = $input;
        });

        $filteredEmitter->start();

        $eventEmitter->emit('event', [5]);
        $eventEmitter->emit('event', [10]);

        $this->assertEquals([10], $container);
    }

    public function testCancelEvent()
    {
        $eventEmitter = new EventEmitter();

        $filteredEmitter = new FilteredEventEmitter(
            $eventEmitter,
            'event',
            function () {
            }
        );

        $filteredEmitter->start();
        $this->assertCount(1, $eventEmitter->listeners('event'));

        $filteredEmitter->cancel();
        $this->assertCount(0, $eventEmitter->listeners('event'));
    }

    public function testCancelByMaxItems()
    {
        $eventEmitter = new EventEmitter();

        $filteredEmitter = new FilteredEventEmitter(
            $eventEmitter,
            'event',
            fn (int $input) => $input === 10,
            maxItems: 3
        );

        $filteredEmitter->start();

        $eventEmitter->emit('event', [5]);
        $eventEmitter->emit('event', [10]);
        $eventEmitter->emit('event', [10]);
        $this->assertCount(1, $eventEmitter->listeners('event'));

        $eventEmitter->emit('event', [10]);
        $this->assertCount(0, $eventEmitter->listeners('event'));
    }

    public function testCancelByTimeout()
    {
        /**
         * @var Mock
         */
        $loop = Mockery::mock('React\EventLoop\LoopInterface');

        /**
         * @var Mock
         */
        $loopMock = Mockery::mock('overload:React\EventLoop\Loop');
        $loopMock->shouldReceive('get')->andReturn(
            $loop
        );

        $canceller = null;

        $loop->shouldReceive('addTimer')
            ->andReturnUsing(
                function (float $seconds, callable $handler) use (&$canceller) {
                    $this->assertEquals(10, $seconds);

                    $canceller = $handler;
                }
            );

        // </mocking

        $eventEmitter = new EventEmitter();

        $filteredEmitter = new FilteredEventEmitter(
            $eventEmitter,
            'event',
            fn (int $input) => $input === 10,
            10
        );

        $filteredEmitter->start();

        $loop->shouldHaveReceived('addTimer')->once();

        $this->assertCount(1, $eventEmitter->listeners('event'));

        $canceller();

        $this->assertCount(0, $eventEmitter->listeners('event'));
    }

    public function testItAcceptsEventHandler()
    {
        $eventHandler = new EventHandler(
            DataMapperFake::get(),
            true
        );

        $filteredEmitter = new FilteredEventEmitter(
            $eventHandler,
            Events::RAW,
            fn (Payload $payload) => $payload->s === 10,
        );

        $container = [];
        $filteredEmitter->on(Events::RAW, function (Payload $payload) use (&$container) {
            $container[] = $payload;
        });

        $filteredEmitter->start();

        $payload = new Payload();
        $payload->t = 'something';
        $payload->s = 10;

        $eventHandler->handle($payload);

        $this->assertCount(1, $container);
    }
}
