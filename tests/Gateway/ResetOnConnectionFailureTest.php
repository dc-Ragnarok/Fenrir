<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway;

use Exception;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway;
use Tests\Ragnarok\Fenrir\Gateway\GatewayTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ResetOnConnectionFailureTest extends GatewayTestCase
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

        $this->loop->shouldReceive('addTimer', 'addPeriodicTimer');
    }

    public function testResume(): void
    {
        $this->gateway->websocket->expects()
            ->open()
            ->with('::resume gateway url::')
            ->andReturn(PromiseFake::reject(new Exception('Fake')))
            ->times(3);

        $this->gateway->websocket->expects()
            ->open()
            ->with(Gateway::WEBSOCKET_URL)
            ->andReturn(PromiseFake::get())
            ->once();

        $this->mockIncomingMessage([
            'op' => 7,
        ]);

        $this->gateway->websocket->shouldHaveReceived('close', [1001, 'reconnecting']);

        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000,
            ],
        ]);

        $this->gateway->websocket->shouldHaveReceived('open', [Gateway::WEBSOCKET_URL]);
    }
}
