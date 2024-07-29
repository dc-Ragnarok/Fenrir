<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\GatewayCloseCodes;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\RecoverableInvalidSessionEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class RecoverableInvalidSessionEventTest extends MockeryTestCase
{
    private DataMapper $mapper;
    private ConnectionInterface&MockInterface $connectionInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new DataMapper(new NullLogger());
        $this->connectionInterface = Mockery::mock(ConnectionInterface::class);
    }

    /**
     * @dataProvider listenerDataProvider
     */
    public function testItListensToTheCorrectRequirements(object $payload, bool $expect): void
    {
        $event = new RecoverableInvalidSessionEvent(
            Mockery::mock(ConnectionInterface::class),
            $this->mapper->map($payload, Payload::class),
            new NullLogger(),
        );

        $this->assertEquals($expect, $event->filter());
    }

    public static function listenerDataProvider(): array
    {
        return [
            'Payload D => true' => [
                'payload' => (object) [
                    'd' => true
                ],
                'expect' => true,
            ],
            'Payload D => false' => [
                'payload' => (object) [
                    'd' => false
                ],
                'expect' => false,
            ]
        ];
    }

    public function testItDisconnectsWithCorrectCode(): void
    {
        $event = new RecoverableInvalidSessionEvent(
            $this->connectionInterface,
            $this->mapper->map((object) ['d' => true], Payload::class),
            new NullLogger(),
        );

        $this->connectionInterface
            ->shouldReceive()
            ->disconnect()
            ->with(GatewayCloseCodes::LIB_INSTANTIATED_RESUME, Mockery::type('string'))
            ->once();

        $event->execute();
    }
}
