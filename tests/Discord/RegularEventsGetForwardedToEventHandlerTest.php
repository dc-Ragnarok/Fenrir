<?php

use Exan\Dhp\EventHandler;
use Tests\Exan\Dhp\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RegularEventsGetForwardedToEventHandlerTest extends DiscordTestCase
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
