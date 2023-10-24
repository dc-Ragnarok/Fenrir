<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Handlers;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\ReadyEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class ReadyEventTest extends MockeryTestCase
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
    public function testItListensToTheCorrectEvent(object $payload, bool $expectation): void
    {
        $event = new ReadyEvent(
            Mockery::mock(ConnectionInterface::class),
            $this->mapper->map($payload, Payload::class),
            new NullLogger(),
        );

        $this->assertEquals($expectation, $event->filter());
    }

    public function listenerDataProvider(): array
    {
        return [
            'Ready event' => [
                'payload' => (object) [
                    't' => Events::READY
                ],
                'expectation' => true,
            ],
            'Other event' => [
                'payload' => (object) [
                    't' => Events::AUTO_MODERATION_ACTION_EXECUTION
                ],
                'expectation' => false,
            ],
            'No type' => [
                'payload' => (object) [],
                'expectation' => false,
            ],
        ];
    }

    /**
     * @dataProvider payloadProvider
     */
    public function testItSetsResumeUrlAndSessionId(object $payload, bool $shouldSet): void
    {
        /** @var MockInterface&ConnectionInterface */
        $connection = Mockery::mock(ConnectionInterface::class);
        $event = new ReadyEvent(
            $connection,
            $this->mapper->map($payload, Payload::class),
            new NullLogger(),
        );

        $resumeExpectation = $connection->expects()
            ->setResumeUrl()
            ->with('::resume gateway url::');

        $sessionExpectation = $connection->expects()
            ->setSessionId()
            ->with('::session id::');

        if ($shouldSet) {
            $resumeExpectation->once();
            $sessionExpectation->once();
        } else {
            $resumeExpectation->never();
            $sessionExpectation->never();
        }

        $event->execute();
    }

    public function payloadProvider(): array
    {
        return [
            'All filled in' => [
                'payload' => (object) [
                    't' => Events::READY,
                    'd' => (object) [
                        'resume_gateway_url' => '::resume gateway url::',
                        'session_id' => '::session id::',
                    ]
                ],
                'expectation' => true,
            ],

            'No resume url' => [
                'payload' => (object) [
                    't' => Events::READY,
                    'd' => (object) [
                        'session_id' => '::session id::',
                    ]
                ],
                'expectation' => false,
            ],

            'No session id' => [
                'payload' => (object) [
                    't' => Events::READY,
                    'd' => (object) [
                        'resume_gateway_url' => '::resume gateway url::',
                    ]
                ],
                'expectation' => false,
            ],

            'No d' => [
                'payload' => (object) [
                    't' => Events::READY,
                ],
                'expectation' => false,
            ],
        ];
    }
}
