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
final class MissedHeartBeatTest extends GatewayTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockIncomingMessage([
            'op' => 0,
            't' => Events::READY,
            's' => 1,
            'd' => [
                'session_id' => '::session id::',
                'resume_gateway_url' => '::resume gateway url::'
            ]
        ]);

        $this->loop->shouldReceive('addPeriodicTimer', 'addTimer')
            ->andReturnUsing(function ($interval, callable $callback) {
                $callback();

                return Mockery::mock(TimerInterface::class);
            });

        $this->loop->shouldReceive('cancelTimer');
    }

    public function testReconnectWhenHeartBeatNotAcknowledged()
    {
        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000
            ]
        ]);

        $this->gateway->websocket->shouldHaveReceived('close', [1001, 'reconnecting']);

        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000,
            ],
        ]);

        $this->assertMessageSent([
            'op' => 6,
            'd' => [
                'token' => '::token::',
                'session_id' => '::session id::',
                'seq' => 1,
            ]
        ]);
    }
}
