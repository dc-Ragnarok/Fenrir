<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\HeartbeatAcknowledgedEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class HeartbeatAcknowledgedEventTest extends MockeryTestCase
{
    public function testItListensTo11(): void
    {
        $this->assertEquals('11', HeartbeatAcknowledgedEvent::getEventName());
    }

    public function testItAcknowledgesAHeartbeat(): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $event = new HeartbeatAcknowledgedEvent(
            $connection,
            Mockery::mock(Payload::class),
            new NullLogger(),
        );

        $this->assertEquals(true, $event->filter());

        $connection->expects()
            ->acknowledgeHeartbeat()
            ->once();

        $event->execute();
    }
}
