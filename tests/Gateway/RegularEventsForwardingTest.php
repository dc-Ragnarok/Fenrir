<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Gateway;

use Exan\Fenrir\EventHandler;
use Mockery;
use Tests\Exan\Fenrir\Gateway\GatewayTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RegularEventsForwardingTest extends GatewayTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->gateway->events = Mockery::mock(EventHandler::class);
        $this->gateway->events->shouldReceive('handle');
    }

    public function testRegularEventsGetForwardedToEventHandler()
    {
        $this->mockIncomingMessage(['op' => 0, 't' => '::some event::']);

        $this->gateway->events->shouldHaveReceived('handle');
    }
}
