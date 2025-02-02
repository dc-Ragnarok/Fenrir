<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Orchestration;

use Carbon\Carbon;
use DateTimeInterface;
use Fakes\Ragnarok\Fenrir\LoopFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Orchestration\Orchestrator;
use Ragnarok\Fenrir\Parts\GatewayBot;
use Ragnarok\Fenrir\Parts\SessionStartLimit;
use Ragnarok\Fenrir\Rest\Gateway as HttpGateway;

class OrchestratorTest extends TestCase
{
    /** @dataProvider orchestrationDataProvider */
    public function testItSpawnsBasedOnGatewayBotInfo(array $gatewayBots, array $expectedSpawns): void
    {
        $loop = new LoopFake();
        /** @var HttpGateway&MockInterface */
        $gateway = Mockery::mock(HttpGateway::class);

        $orchestrator = new Orchestrator($loop, $gateway);

        $gateway->shouldReceive()
            ->getBot()
            ->andReturnUsing(function () use (&$gatewayBots) {
                $this->assertNotEmpty($gatewayBots, 'GatewayBot requested unexpectedly.');

                return PromiseFake::get(array_shift($gatewayBots));
            })
            ->once();

        $spawned = [];
        $orchestrator->on(Orchestrator::ALLOW_SPAWN, function (int $shard, int $totalShards) use (&$spawned) {
            $spawned[] = [$shard, $totalShards];
        });

        $orchestrator->init();

        foreach ($expectedSpawns as $expectedSpawn) {
            $this->assertEquals($expectedSpawn, $spawned);
            $spawned = [];
            $loop->runTimers();
        }

        $this->assertEmpty($spawned);
    }

    private static function getGatewayBot(
        int $shards,
        int $sessionStartLimitTotal,
        int $sessionStartLimitRemaining,
        DateTimeInterface $sessionStartLimitResetAfter,
        int $sessionStartLimitConcurrency,
        string $url = '::url::'
    ): GatewayBot {
        $gatewayBot = new GatewayBot();
        $gatewayBot->url = $url;
        $gatewayBot->shards = $shards;

        $gatewayBot->session_start_limit = new SessionStartLimit();
        $gatewayBot->session_start_limit->total = $sessionStartLimitTotal;
        $gatewayBot->session_start_limit->remaining = $sessionStartLimitRemaining;
        $gatewayBot->session_start_limit->reset_after = $sessionStartLimitResetAfter->getTimestamp();
        $gatewayBot->session_start_limit->max_concurrency = $sessionStartLimitConcurrency;

        return $gatewayBot;
    }

    public static function orchestrationDataProvider()
    {
        return [
            'Ideal conditions, total % concurrency == 0' => [
                'gatewayBots' => [
                    self::getGatewayBot(
                        15,
                        15,
                        15,
                        Carbon::now()->addMinutes(5),
                        5,
                    ),
                ],
                'expectedSpawns' => [
                    [
                        [0, 15],
                        [1, 15],
                        [2, 15],
                        [3, 15],
                        [4, 15],
                    ],
                    [
                        [5, 15],
                        [6, 15],
                        [7, 15],
                        [8, 15],
                        [9, 15],
                    ],
                    [
                        [10, 15],
                        [11, 15],
                        [12, 15],
                        [13, 15],
                        [14, 15],
                    ],
                ],
            ],
        ];
    }
}
