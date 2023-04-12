<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Exception;
use Fakes\Ragnarok\Fenrir\GatewayFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Ragnarok\Fenrir\Exceptions\Retrier\TooManyRetriesException;
use Ragnarok\Fenrir\Retrier;

use function React\Async\await;

class RetrierTest extends MockeryTestCase
{
    public function testItDoesNotRunTheActionMultipleTimesForHappyFlowAsync(): void
    {
        $gateway = GatewayFake::get();
        $gateway->expects()
            ->connect()
            ->andReturns(PromiseFake::get('I promise this will work'))
            ->once();

        $result = await(Retrier::retryAsync(3, function () use ($gateway) {
            return $gateway->connect();
        }));

        $this->assertEquals('I promise this will work', $result);
    }

    public function testItRetriesTheSetNumberOfTimesAsync(): void
    {
        $gateway = GatewayFake::get();
        $gateway->expects()
            ->connect()
            ->andReturns(PromiseFake::reject(new Exception('Wow, this is an exception')))
            ->times(3);

        $this->expectException(TooManyRetriesException::class);

        await(Retrier::retryAsync(3, function () use ($gateway) {
            return $gateway->connect();
        }));
    }

    public function testItIndicatesWhatAttemptItIsOn(): void
    {
        $gateway = GatewayFake::get();
        $gateway->expects()
            ->connect()
            ->andReturns(PromiseFake::reject(new Exception('Wow, this is an exception')))
            ->times(3);

        $attempts = [];

        try {
            await(Retrier::retryAsync(3, function (int $attempt) use ($gateway, &$attempts) {
                $attempts[] = $attempt;
                return $gateway->connect();
            }));
        } catch (TooManyRetriesException) {
        }

        $this->assertEquals(range(0, 2), $attempts);
    }
}
