<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway;

use Ragnarok\Fenrir\Const\Events;
use Mockery;
use React\EventLoop\TimerInterface;
use Tests\Ragnarok\Fenrir\Gateway\GatewayTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class HandlesHeartbeatTest extends GatewayTestCase
{
    /**
     * @var Mock
     */
    private $timerInterface;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loop->shouldReceive('addPeriodicTimer')->andReturnUsing(function ($interval, callable $callback) {
            $callback();

            return Mockery::mock(TimerInterface::class);
        });

        $this->timerInterface = Mockery::mock(TimerInterface::class);

        $this->loop->shouldReceive('addTimer')->andReturn($this->timerInterface);
        $this->loop->shouldReceive('cancelTimer');
    }

    public function testHandlesHello()
    {
        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000
            ]
        ]);

        $this->assertMessageSent([
            'op' => 2,
            'd' => [
                'token' => '::token::',
                'intents' => 123,
                'properties' => [
                    'os' => PHP_OS,
                    'browser' => 'Ragnarok\Fenrir',
                    'device' => 'Ragnarok\Fenrir',
                ]
            ]
        ]);

        $this->assertMessageSent([
            'op' => 1,
            'd' => null
        ], false);
    }

    public function testAcknowledgesHearbeat()
    {
        // 10 starts sending heartbeats, which starts a timer to reconnect
        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000
            ]
        ]);

        // 11 acknowledges the hearbeat send by client, which should remove the timer to reconnect
        $this->mockIncomingMessage([
            'op' => 11,
        ]);

        $this->loop->shouldHaveReceived('cancelTimer', [$this->timerInterface]);
    }

    public function testShouldNotCancelTimerIfNoneIsSet()
    {
        // 11 acknowledges the hearbeat send by client
        $this->mockIncomingMessage([
            'op' => 11,
        ]);

        $this->loop->shouldNotHaveReceived('cancelTimer');
    }

    public function testShouldStopHeartBeatForReconnect()
    {
        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000
            ]
        ]);

        $this->mockIncomingMessage([
            'op' => 0,
            't' => Events::READY,
            's' => 1,
            'd' => [
                'session_id' => '::session id::',
                'resume_gateway_url' => '::resume gateway url::'
            ]
        ]);

        $this->mockIncomingMessage([
            'op' => 7,
        ]);

        $this->loop->shouldHaveReceived('cancelTimer');
    }
}
