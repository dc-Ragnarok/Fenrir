<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway;

use Ragnarok\Fenrir\EventHandler;
use Mockery;
use Tests\Ragnarok\Fenrir\Gateway\GatewayTestCase;

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

    public function testRegularEventsGetForwardedToEventHandler(): void
    {
        $this->mockIncomingMessage(['op' => 0, 't' => '::some event::']);

        $this->gateway->events->shouldHaveReceived('handle');
    }
}
