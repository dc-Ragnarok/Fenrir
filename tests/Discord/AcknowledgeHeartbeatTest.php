<?php

use Mockery\Mock;
use React\EventLoop\TimerInterface;
use Tests\Exan\Dhp\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class AcknowledgeHeartbeatTest extends DiscordTestCase
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
        });

        $this->timerInterface = Mockery::mock(TimerInterface::class);

        $this->loop->shouldReceive('addTimer')->andReturn($this->timerInterface);
        $this->loop->shouldReceive('cancelTimer');
    }

    public function testHandlesHello()
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
}
