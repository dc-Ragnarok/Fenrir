<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Bucket;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Loop;

use function Clue\React\Block\await;
use function Clue\React\Block\awaitAll;

class BucketTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testLimit(): void
    {
        $bucket = new Bucket(Loop::get(), 2, 1);

        $spy = Mockery::spy(static function () {
        });

        $start = microtime(true);

        awaitAll([$bucket->run($spy), $bucket->run($spy)]);

        $mid = microtime(true);
        $spy->shouldHaveBeenCalled()->twice();

        await($bucket->run($spy));

        $end = microtime(true);

        $this->assertGreaterThanOrEqual(1, $end - $start);
        $this->assertGreaterThanOrEqual(0.99, $end - $mid);
    }

    public function testRejectsPromiseOnError(): void
    {
        $bucket = new Bucket(Loop::get(), 2, 1);

        $errorThrower = static function () {
            throw new \Exception('::exception::');
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('::exception::');

        await($bucket->run($errorThrower));
    }
}
