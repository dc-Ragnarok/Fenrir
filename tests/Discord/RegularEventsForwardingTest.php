<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Discord;

use Exan\Finrir\EventHandler;
use Mockery;
use Tests\Exan\Finrir\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RegularEventsForwardingTest extends DiscordTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->discord->events = Mockery::mock(EventHandler::class);
        $this->discord->events->shouldReceive('handle');
    }

    public function testRegularEventsGetForwardedToEventHandler()
    {
        $this->mockIncomingMessage(['op' => 0, 't' => '::some event::']);

        $this->discord->events->shouldHaveReceived('handle');
    }
}
