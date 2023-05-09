<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\PassthroughEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class PassthroughEventTest extends MockeryTestCase
{
    private DataMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new DataMapper(new NullLogger());
    }
    public function testItListensTo11()
    {
        $this->assertEquals('0', PassthroughEvent::getEventName());
    }

    public function testItForwardsEvents()
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $payload = $this->mapper->map([], Payload::class);

        $event = new PassthroughEvent(
            $connection,
            $payload,
            new NullLogger(),
        );

        $connection->expects()
            ->getSequence()
            ->once();

        /** @var EventHandler&MockInterface */
        $eventHandler = Mockery::mock(EventHandler::class);
        $connection->expects()
            ->getEventHandler()
            ->andReturns($eventHandler)
            ->once();

        $eventHandler->expects()
            ->handle()
            ->with($payload)
            ->once();

        $event->execute();
    }

    public function testItUpdatesSequence()
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $payload = $this->mapper->map(['s' => 123], Payload::class);

        $event = new PassthroughEvent(
            $connection,
            $payload,
            new NullLogger(),
        );

        $connection->expects()
            ->getSequence()
            ->once();

        /** @var EventHandler&MockInterface */
        $eventHandler = Mockery::mock(EventHandler::class);
        $connection->expects()
            ->getEventHandler()
            ->andReturns($eventHandler)
            ->once();

        $eventHandler->expects()
            ->handle()
            ->with($payload)
            ->once();

        $connection->expects()
            ->setSequence()
            ->with(123)
            ->once();

        $event->execute();
    }

    public function testItDoesNotUpdateSequenceIfCurrentSequenceIsHigherThanIncoming()
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $payload = $this->mapper->map(['s' => 123], Payload::class);

        $event = new PassthroughEvent(
            $connection,
            $payload,
            new NullLogger(),
        );

        $connection->expects()
            ->getSequence()
            ->andReturns(456)
            ->once();

        /** @var EventHandler&MockInterface */
        $eventHandler = Mockery::mock(EventHandler::class);
        $connection->expects()
            ->getEventHandler()
            ->andReturns($eventHandler)
            ->once();

        $eventHandler->expects()
            ->handle()
            ->with($payload)
            ->once();

        $connection->expects()
            ->setSequence()
            ->with(123)
            ->never();

        $event->execute();
    }

    public function testItSetsSequenceIfNoCurrentSequenceIsSet()
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $payload = $this->mapper->map(['s' => 123], Payload::class);

        $event = new PassthroughEvent(
            $connection,
            $payload,
            new NullLogger(),
        );

        $connection->expects()
            ->getSequence()
            ->andReturns(null)
            ->once();

        /** @var EventHandler&MockInterface */
        $eventHandler = Mockery::mock(EventHandler::class);
        $connection->expects()
            ->getEventHandler()
            ->andReturns($eventHandler)
            ->once();

        $eventHandler->expects()
            ->handle()
            ->with($payload)
            ->once();

        $connection->expects()
            ->setSequence()
            ->with(123)
            ->once();

        $event->execute();
    }
}
