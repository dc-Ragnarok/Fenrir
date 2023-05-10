<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers\Meta;

use Exan\Eventer\Eventer;
use Exception;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyResumeEvent;
use Ragnarok\Fenrir\Gateway\Handlers\Meta\UnacknowledgedHeartbeatEvent;

class UnacknowledgedHeartbeatEventTest extends MockeryTestCase
{
    public function testItListensToUnacknowledgedHeartbeat(): void
    {
        $this->assertEquals(MetaEvents::UNACKNOWLEDGED_HEARTBEAT, UnacknowledgedHeartbeatEvent::getEventName());
    }

    public function testItReconnectsToDiscord(): void
    {
        /** @var ConnectionInterface&MockInterface */
        $connection = Mockery::mock(ConnectionInterface::class);

        $connection->expects()
            ->stopAutomaticHeartbeats()
            ->once();

        $connection->expects()
            ->getResumeUrl()
            ->andReturns('::resume url::')
            ->twice();

        $connection->expects()
            ->getSessionId()
            ->andReturns('::session id::')
            ->once();

        $connection->expects()
            ->disconnect()
            ->with(1004, Mockery::any())
            ->once();

        $connection->expects()
            ->connect()
            ->with('::resume url::')
            ->andReturns(PromiseFake::get())
            ->once();

        /** @var Eventer&MockInterface */
        $rawHandler = Mockery::mock(Eventer::class);
        $rawHandler->expects()
            ->registerOnce()
            ->with(IdentifyResumeEvent::class)
            ->once();

        $connection->expects()
            ->getRawHandler()
            ->andReturns($rawHandler)
            ->once();

        $event = new UnacknowledgedHeartbeatEvent(
            $connection,
            new NullLogger(),
        );

        $event->execute();

        $this->assertTrue($event->filter());
    }

    public function testItOpensAFreshConnectionIfItCantResume(): void
    {
        /** @var ConnectionInterface&MockInterface */
        $connection = Mockery::mock(ConnectionInterface::class);

        $connection->expects()
            ->stopAutomaticHeartbeats()
            ->once();

        $connection->expects()
            ->getResumeUrl()
            ->andReturns(null)
            ->once();

        $connection->expects()
            ->disconnect()
            ->with(1001, Mockery::any())
            ->once();

        $connection->expects()
            ->getDefaultUrl()
            ->andReturns('::default url::')
            ->once();

        $connection->expects()
            ->connect()
            ->with('::default url::')
            ->andReturns(PromiseFake::get())
            ->once();

        /** @var Eventer&MockInterface */
        $rawHandler = Mockery::mock(Eventer::class);
        $rawHandler->expects()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->once();

        $connection->expects()
            ->getRawHandler()
            ->andReturns($rawHandler)
            ->once();

        $event = new UnacknowledgedHeartbeatEvent(
            $connection,
            new NullLogger(),
        );

        $event->execute();
    }

    public function testItOpensAFreshConnectionIfResumingFails(): void
    {
        /** @var ConnectionInterface&MockInterface */
        $connection = Mockery::mock(ConnectionInterface::class);

        $connection->expects()
            ->stopAutomaticHeartbeats()
            ->once();

        $connection->expects()
            ->getResumeUrl()
            ->andReturns('::resume url::')
            ->times(4);

        $connection->expects()
            ->getSessionId()
            ->andReturns('::session id::')
            ->once();

        $connection->expects()
            ->disconnect()
            ->with(1004, Mockery::any())
            ->once();

        $connection->expects()
            ->connect()
            ->with('::resume url::')
            ->andReturns(PromiseFake::reject(new Exception(':(')))
            ->times(3);

        $connection->expects()
            ->getDefaultUrl()
            ->andReturns('::default url::')
            ->once();

        $connection->expects()
            ->connect()
            ->with('::default url::')
            ->andReturns(PromiseFake::get())
            ->once();

         /** @var Eventer&MockInterface */
         $rawHandler = Mockery::mock(Eventer::class);
         $rawHandler->expects()
             ->registerOnce()
             ->with(IdentifyHelloEvent::class)
             ->once();

         $connection->expects()
             ->getRawHandler()
             ->andReturns($rawHandler)
             ->once();

        $event = new UnacknowledgedHeartbeatEvent(
            $connection,
            new NullLogger(),
        );

         $event->execute();
    }
}
