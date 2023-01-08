<?php

use Tests\Exan\Dhp\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class HandlesHelloTest extends DiscordTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loop->shouldReceive('addPeriodicTimer')->andReturnUsing(function ($interval, callable $callback) {
            $callback();
        });

        $this->loop->shouldReceive('addTimer');
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
                    'browser' => 'Exan\DHP',
                    'device' => 'Exan\DHP',
                ]
            ]
        ]);

        $this->assertMessageSent([
            'op' => 1,
            'd' => null
        ]);
    }
}
