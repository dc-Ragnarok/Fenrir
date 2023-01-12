<?php

ini_set('memory_limit','-1');

use Exan\Dhp\Const\Events;
use Exan\Dhp\EventHandler;
use Mockery\Mock;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Tests\Exan\Dhp\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ResumeTest extends DiscordTestCase
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

    public function testResume()
    {
        $this->mockIncomingMessage([
            'op' => 7,
        ]);

        $this->discord->websocket->shouldHaveReceived('close', [1001, 'reconnecting']);

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

        // Client should not identify when resuming
        $this->assertMessageNotSent([
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
    }

    public function testReconnectAndResume()
    {
        $this->mockIncomingMessage([
            'op' => 9,
            'd' => true
        ]);

        $this->discord->websocket->shouldNotHaveReceived('close', [1001, 'reconnecting']);

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

        // Client should not identify when resuming
        $this->assertMessageNotSent([
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
    }

    public function testReconnectAndReidentify()
    {
        $this->mockIncomingMessage([
            'op' => 9,
        ]);

        $this->discord->websocket->shouldNotHaveReceived('close', [1001, 'reconnecting']);

        $this->mockIncomingMessage([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000,
            ],
        ]);

        // Client should not identify when (op = 9 && d !== true)
        $this->assertMessageNotSent([
            'op' => 6,
            'd' => [
                'token' => '::token::',
                'session_id' => '::session id::',
                'seq' => 1,
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
    }
}
