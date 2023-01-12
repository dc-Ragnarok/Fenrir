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

        $this->discord->events = Mockery::mock(EventHandler::class);
        $this->discord->events->shouldReceive('handle');

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

        $this->connection->shouldReceive('close');
    }

    public function testReconnect()
    {
        /**
         * @var Closure
         */
        $newPayloadHandler = null;

        $newConnection = Mockery::mock(WebSocket::class);
        $newConnection->shouldReceive('on')->andReturnUsing(function (string $event, callable $handler) use (&$newPayloadHandler) {
            $newPayloadHandler = $handler;
        });

        $newConnection->shouldReceive('send');

        /**
         * @var Mock
         */
        $promiseMock = Mockery::mock(Promise::class);
        $promiseMock->shouldReceive('then')->andReturnUsing(function (callable $callback, callable $error) use ($newConnection) {
            $callback($newConnection);
        });

        $this->ratchetConnectorMockOptions['::resume gateway url::'] = $promiseMock;

        $this->mockIncomingMessage([
            'op' => 7,
        ]);

        $this->connection->shouldHaveReceived('close', [1001, 'reconnecting']);

        /**
         * @var Mock
         */
        $messageMock = Mockery::mock(MessageInterface::class);
        $messageMock->shouldReceive('__toString')->andReturn(json_encode([
            'op' => 10,
            'd' => [
                'heartbeat_interval' => 20000
            ]
        ]));

        $newPayloadHandler($messageMock);

        $newConnection->shouldHaveReceived('send', [json_encode([
            'op' => 6,
            'd' => [
                'token' => '::token::',
                'session_id' => '::session id::',
                'seq' => 1,
            ]
        ])]);

        // Client should not identify when resuming
        $newConnection->shouldNotHaveReceived('send', [json_encode([
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
        ])]);
    }
}
