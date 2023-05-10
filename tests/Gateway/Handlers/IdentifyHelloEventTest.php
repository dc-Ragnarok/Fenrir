<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class IdentifyHelloEventTest extends MockeryTestCase
{
    private DataMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new DataMapper(new NullLogger());
    }

    public function testItListensTo10(): void
    {
        $this->assertEquals(OpCodes::HELLO, IdentifyHelloEvent::getEventName());
    }

    public function testItAcknowledgesAHeartbeat(): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $event = new IdentifyHelloEvent(
            $connection,
            $this->mapper->map([
                'd' => (object) [
                    'heartbeat_interval' => 123
                ]
            ], Payload::class),
            new NullLogger(),
        );

        $connection->expects()
            ->identify()
            ->once();

        $connection->expects()
            ->sendHeartbeat()
            ->once();

        $connection->expects()
            ->startAutomaticHeartbeats()
            ->with(123)
            ->once();

        $event->execute();
    }
}
