<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers\Meta;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\GatewayCloseCodes;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\Meta\UnacknowledgedHeartbeatEvent;

class UnacknowledgedHeartbeatEventTest extends MockeryTestCase
{
    public function testItListensToUnacknowledgedHeartbeat(): void
    {
        $this->assertEquals(MetaEvents::UNACKNOWLEDGED_HEARTBEAT, UnacknowledgedHeartbeatEvent::getEventName());
    }

    public function testItDisconnectsWithRightCode(): void
    {
        $connection = Mockery::mock(ConnectionInterface::class);

        $event = new UnacknowledgedHeartbeatEvent(
            $connection,
            new NullLogger()
        );

        $connection
            ->shouldReceive()
            ->disconnect()
            ->with(GatewayCloseCodes::LIB_INSTANTIATED_RECONNECT, Mockery::type('string'))
            ->once();

        $event->execute();
    }
}
