<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Exan\Eventer\Eventer;
use Exception;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\InvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class InvalidSessionEventTest extends MockeryTestCase
{
    private DataMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new DataMapper(new NullLogger());
    }

    /**
     * @dataProvider listenerDataProvider
     */
    public function testItListensToTheCorrectRequirements(object $payload, bool $expect): void
    {
        $event = new InvalidSessionEvent(
            Mockery::mock(ConnectionInterface::class),
            $this->mapper->map($payload, Payload::class),
            new NullLogger(),
        );

        $this->assertEquals($expect, $event->filter());
    }

    public function listenerDataProvider(): array
    {
        return [
            'Payload D => true' => [
                'payload' => (object) [
                    'd' => true
                ],
                'expect' => false,
            ],
            'Payload D => false' => [
                'payload' => (object) [
                    'd' => false
                ],
                'expect' => true,
            ]
        ];
    }

    public function testItReconnects(): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);

        $event = new InvalidSessionEvent(
            $connection,
            $this->mapper->map((object) ['d' => false], Payload::class),
            new NullLogger(),
        );

        $connection->expects()
            ->stopAutomaticHeartbeats()
            ->once();

        $connection->shouldReceive()
            ->disconnect()
            ->with(1001, Mockery::any())
            ->once();

        $connection->expects()
            ->resetSequence()
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

        /** @var MockInterface&Eventer */
        $rawHandler = Mockery::mock(Eventer::class);
        $connection->expects()
            ->getRawHandler()
            ->andReturns($rawHandler)
            ->once();

        $rawHandler->expects()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->once();

        $event->execute();
    }

    public function testItTriesConnectingSeveralTimes(): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);

        $event = new InvalidSessionEvent(
            $connection,
            $this->mapper->map((object) ['d' => false], Payload::class),
            new NullLogger(),
        );

        $connection->expects()
            ->stopAutomaticHeartbeats()
            ->once();

        $connection->shouldReceive()
            ->disconnect()
            ->with(1001, Mockery::any())
            ->once();

        $connection->expects()
            ->resetSequence()
            ->once();

        $connection->expects()
            ->getDefaultUrl()
            ->andReturns('::default url::')
            ->times(3);

        $connection->expects()
            ->connect()
            ->with('::default url::')
            ->andReturns(PromiseFake::reject(new Exception('Oh no, the connection went wrong :(')))
            ->times(3);

        $event->execute();
    }
}
