<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway;

use Exan\Eventer\Eventer;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Fakes\Ragnarok\Fenrir\RetrierFake;
use Fakes\Ragnarok\Fenrir\WebsocketFake;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\Constants\WebsocketEvents;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Connection;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyResumeEvent;
use Ragnarok\Fenrir\Gateway\Helpers\PresenceUpdateBuilder;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Ragnarok\Fenrir\Gateway\Shard;
use Ragnarok\Fenrir\Websocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use ReflectionProperty;

use function React\Async\await;

class ConnectionTest extends MockeryTestCase
{
    private const EXPECTED_QUERY_PARAMS = [
        'v' => 10,
        'encoding' => 'json',
        'compress' => 'zlib-stream'
    ];

    public function testGetDefaultUrl(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $this->assertEquals('wss://gateway.discord.gg/', $connection->getDefaultUrl());
    }

    public function testSequence(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $this->assertNull($connection->getSequence());

        $connection->setSequence(123);
        $this->assertEquals(123, $connection->getSequence());
    }

    public function testConnect(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->open()
            ->with('::ws url::?' . http_build_query(self::EXPECTED_QUERY_PARAMS))
            ->andReturns(PromiseFake::get('::return::'))
            ->once();

        $this->assertEquals('::return::', await($connection->connect('::ws url::')));
    }

    public function testDisconnect(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->close()
            ->with(1234, '::reason::')
            ->once();

        $connection->disconnect(1234, '::reason::');
    }

    public function testSessionId(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $this->assertNull($connection->getSessionId());

        $connection->setSessionId('::session id::');
        $this->assertEquals('::session id::', $connection->getSessionId());
    }

    public function testResumeUrl(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $this->assertNull($connection->getResumeUrl());

        $connection->setResumeUrl('::resume url::');
        $this->assertEquals('::resume url::', $connection->getResumeUrl());
    }

    public function testSendHeartbeat(): void
    {
        /** @var LoopInterface&MockInterface */
        $loop = Mockery::mock(LoopInterface::class);

        $loop->expects()
            ->addTimer()
            ->withAnyArgs()
            ->andReturns(Mockery::mock(TimerInterface::class))
            ->twice();

        $connection = new Connection(
            $loop,
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(['op' => 1, 'd' => null], false)
            ->once();

        $connection->sendHeartbeat();

        $connection->setSequence(123);

        $websocket->expects()
            ->sendAsJson()
            ->with(['op' => 1, 'd' => 123], false)
            ->once();

        $connection->sendHeartbeat();
    }

    public function testItEmitsAnEventForMissedHeartbeatAcknowledgement(): void
    {
        /** @var LoopInterface&MockInterface */
        $loop = Mockery::mock(LoopInterface::class);

        $loop->expects()
            ->addTimer()
            ->withAnyArgs()
            ->andReturnUsing(function (float|int $seconds, callable $handler) {
                $handler();

                return Mockery::mock(TimerInterface::class);
            })
            ->once();

        /** @var Eventer&MockInterface */
        $meta = Mockery::mock(Eventer::class);

        $meta->shouldReceive()
            ->register()
            ->withAnyArgs();

        $logger = new NullLogger();
        $connection = new Connection(
            $loop,
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
            meta: $meta,
            logger: $logger
        );

        $meta->expects()
            ->emit()
            ->with(MetaEvents::UNACKNOWLEDGED_HEARTBEAT, [$connection, $logger])
            ->once();

        $connection->sendHeartbeat();
    }

    public function testItCanAcknowledgeHeartbeats(): void
    {
        /** @var LoopInterface&MockInterface */
        $loop = Mockery::mock(LoopInterface::class);

        $timer = Mockery::mock(TimerInterface::class);
        $loop->expects()
            ->addTimer()
            ->withAnyArgs()
            ->andReturns($timer)
            ->once();

        $connection = new Connection(
            $loop,
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->withAnyArgs()
            ->once();

        $connection->sendHeartbeat();

        $loop->expects()
            ->cancelTimer()
            ->with($timer)
            ->once();

        $connection->acknowledgeHeartbeat();
    }

    public function testItCanSendHeartbeatsAutomatically(): void
    {
        /** @var LoopInterface&MockInterface */
        $loop = Mockery::mock(LoopInterface::class);

        $loop->expects()
            ->addTimer()
            ->withAnyArgs()
            ->andReturns(Mockery::mock(TimerInterface::class))
            ->once();

        $timer = Mockery::mock(TimerInterface::class);
        $loop->expects()
            ->addPeriodicTimer()
            ->withAnyArgs()
            ->andReturnUsing(function (float|int $seconds, callable $handler) use ($timer) {
                $this->assertEquals(10, $seconds);
                $handler();

                return $timer;
            })
            ->once();

        $connection = new Connection(
            $loop,
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(['op' => 1, 'd' => null], false)
            ->once();

        $connection->startAutomaticHeartbeats(10000);
    }

    public function testItReturnsEventHandlers(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $this->assertInstanceOf(EventHandler::class, $connection->getEventHandler());
    }

    public function testItIdentifies(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(123),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(Mockery::on(function ($payload) {
                $this->assertEquals(2, $payload['op']);
                $this->assertEquals('::token::', $payload['d']['token']);
                $this->assertEquals(123, $payload['d']['intents']);

                return true;
            }), true)
            ->once();

        $connection->identify();
    }

    public function testItIdentifiesWithShards(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(123),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        $connection->shard(new Shard(1, 16));

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(Mockery::on(function ($payload) {
                $this->assertEquals(2, $payload['op']);
                $this->assertEquals('::token::', $payload['d']['token']);
                $this->assertEquals(123, $payload['d']['intents']);
                $this->assertEquals([1, 16], $payload['d']['shard']);

                return true;
            }), true)
            ->once();

        $connection->identify();
    }

    public function testItResumes(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(123),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(Mockery::on(function ($payload) {
                $this->assertEquals(6, $payload['op']);
                $this->assertEquals('::token::', $payload['d']['token']);
                $this->assertEquals('::session id::', $payload['d']['session_id']);
                $this->assertNull($payload['d']['seq']);

                return true;
            }), true)
            ->once();

        $connection->setSessionId('::session id::');

        $connection->resume();

        $websocket->expects()
            ->sendAsJson()
            ->with(Mockery::on(function ($payload) {
                $this->assertEquals(6, $payload['op']);
                $this->assertEquals('::token::', $payload['d']['token']);
                $this->assertEquals('::session id::', $payload['d']['session_id']);
                $this->assertEquals(123, $payload['d']['seq']);

                return true;
            }), true)
            ->once();

        $connection->setSequence(123);

        $connection->resume();
    }

    public function testOpen(): void
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->open()
            ->with(Mockery::on(function (string $url) {
                $this->assertMatchesRegularExpression('/wss:\/\/gateway.discord.gg\/\?v=(\d+)/', $url);

                return true;
            }))
            ->once();

        $connection->open();
    }

    public function testItEmitsGatewayMessagesAsEvents(): void
    {
        /** @var Eventer&MockInterface */
        $raw = Mockery::mock(Eventer::class);

        $raw->shouldReceive()
            ->register()
            ->withAnyArgs();

        $raw->shouldReceive()
            ->registerOnce()
            ->withAnyArgs();

        $loop = Mockery::mock(LoopInterface::class);
        $loop->shouldReceive('futureTick')
            ->once()
            ->with(Mockery::on(function ($callback) {
                $callback(); // вызываем вручную
                return true;
            }));

        $connection = new Connection(
            $loop,
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
            raw: $raw,
        );

        $websocket = (new ReflectionProperty($connection, 'websocket'))->getValue($connection);

        $raw->expects()
            ->emit()
            ->with('1', Mockery::on(function ($args) use ($connection) {
                $this->assertEquals($connection, $args[0]);
                $this->assertInstanceOf(Payload::class, $args[1]);
                $this->assertInstanceOf(LoggerInterface::class, $args[2]);

                return true;
            }));

        /** @var MessageInterface&MockInterface */
        $message = Mockery::mock(MessageInterface::class);
        $message->expects()
            ->getPayload()
            ->andReturns(zlib_encode('{"op":1}', ZLIB_ENCODING_DEFLATE) . "\x00\x00\xff\xff")
            ->once();

        $websocket->emit(WebsocketEvents::MESSAGE, [$message]);
    }

    public function testItSendsPresenceUpdates()
    {
        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(123),
            new DataMapper(new NullLogger()),
            new WebsocketFake(),
        );

        /** @var MockInterface&Websocket */
        $websocket = Mockery::mock(Websocket::class);
        (new ReflectionProperty($connection, 'websocket'))->setValue($connection, $websocket);

        $websocket->expects()
            ->sendAsJson()
            ->with(Mockery::on(function ($payload) {
                $this->assertEquals(3, $payload['op']);
                $this->assertEquals(['::presence update::'], $payload['d']);

                return true;
            }), true)
            ->once();

        /** @var MockInterface&PresenceUpdateBuilder */
        $presenceUpdate = Mockery::mock(PresenceUpdateBuilder::class);
        $presenceUpdate->shouldReceive()
            ->get()
            ->andReturn(['::presence update::']);

        $connection->updatePresence($presenceUpdate);
    }

    /**
     * @dataProvider reconnectCloseCodesProvider
     */
    public function testItReconnectsWhenWebsocketConnectionClosedWithCertainCodes(int $code)
    {
        $websocket = new WebsocketFake();

        $raw = Mockery::mock(Eventer::class);

        $raw->shouldReceive()
            ->register()
            ->withAnyArgs();

        $raw->shouldReceive()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->twice();

        new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(1),
            DataMapperFake::get(),
            $websocket,
            raw: $raw,
            retrier: new RetrierFake(),
        );

        $websocket->emit(WebsocketEvents::CLOSE, [$code, 'reason']);

        $this->assertEquals([Connection::DEFAULT_WEBSOCKET_URL . '?' . http_build_query(self::EXPECTED_QUERY_PARAMS)], $websocket->openings);
    }

    public static function reconnectCloseCodesProvider(): array
    {
        return [
            [1001],
            [4003],
            [4007],
            [4009],
        ];
    }

    /**
     * @dataProvider resumeCloseCodesProvider
     */
    public function testItResumesWhenWebsocketConnectionClosedWithCertainCodes(int $code)
    {
        $websocket = new WebsocketFake();
        $raw = Mockery::mock(Eventer::class);

        $raw->shouldReceive()
            ->register()
            ->withAnyArgs();

        $raw->shouldReceive()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->once();

        $raw->shouldReceive()
            ->registerOnce()
            ->with(IdentifyResumeEvent::class)
            ->once();

        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(1),
            DataMapperFake::get(),
            $websocket,
            raw: $raw,
            retrier: new RetrierFake(),
        );

        $connection->setResumeUrl('::resume url::');
        $connection->setSessionId('::session id::');

        $websocket->emit(WebsocketEvents::CLOSE, [$code, 'reason']);

        $this->assertEquals(['::resume url::?' . http_build_query(self::EXPECTED_QUERY_PARAMS)], $websocket->openings);
    }

    /**
     * @dataProvider resumeCloseCodesProvider
     */
    public function testItReconnectsIfMissingResumeUrl(int $code)
    {
        $websocket = new WebsocketFake();

        $raw = Mockery::mock(Eventer::class);

        $raw->shouldReceive()
            ->register()
            ->withAnyArgs();

        $raw->shouldReceive()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->twice();

        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(1),
            DataMapperFake::get(),
            $websocket,
            raw: $raw,
            retrier: new RetrierFake(),
        );

        $connection->setSessionId('::session id::');

        $websocket->emit(WebsocketEvents::CLOSE, [$code, 'reason']);

        $this->assertEquals([Connection::DEFAULT_WEBSOCKET_URL . '?' . http_build_query(self::EXPECTED_QUERY_PARAMS)], $websocket->openings);
    }

    /**
     * @dataProvider resumeCloseCodesProvider
     */
    public function testItReconnectsIfMissingSessionId(int $code)
    {
        $websocket = new WebsocketFake();

        $raw = Mockery::mock(Eventer::class);

        $raw->shouldReceive()
            ->register()
            ->withAnyArgs();

        $raw->shouldReceive()
            ->registerOnce()
            ->with(IdentifyHelloEvent::class)
            ->twice();

        $connection = new Connection(
            Mockery::mock(LoopInterface::class),
            '::token::',
            new Bitwise(1),
            DataMapperFake::get(),
            $websocket,
            raw: $raw,
            retrier: new RetrierFake(),
        );

        $connection->setResumeUrl('::resume url::');

        $websocket->emit(WebsocketEvents::CLOSE, [$code, 'reason']);

        $this->assertEquals([Connection::DEFAULT_WEBSOCKET_URL . '?' . http_build_query(self::EXPECTED_QUERY_PARAMS)], $websocket->openings);
    }

    public static function resumeCloseCodesProvider(): array
    {
        return [
            [1003],
            [4000],
            [4001],
            [4002],
            [4005],
            [4008],
        ];
    }
}
