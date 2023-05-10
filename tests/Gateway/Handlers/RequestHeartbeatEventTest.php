<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\RequestHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class RequestHeartbeatEventTest extends MockeryTestCase
{
    public function testItListensTo1(): void
    {
        $this->assertEquals(OpCodes::HEARTBEAT, RequestHeartbeatEvent::getEventName());
    }

    public function testItAcknowledgesAHeartbeat(): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $event = new RequestHeartbeatEvent(
            $connection,
            Mockery::mock(Payload::class),
            new NullLogger(),
        );

        $connection->expects()
            ->sendHeartbeat()
            ->once();

        $event->execute();
    }
}
