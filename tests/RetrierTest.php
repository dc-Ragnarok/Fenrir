<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Exception;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Ragnarok\Fenrir\Exceptions\Retrier\TooManyRetriesException;
use Ragnarok\Fenrir\Retrier;

use function React\Async\await;

class RetrierTest extends MockeryTestCase
{
    public function testItDoesNotRunTheActionMultipleTimesForHappyFlowAsync(): void
    {
        $result = await(Retrier::retryAsync(3, function () {
            return PromiseFake::get('Success');
        }));

        $this->assertEquals('Success', $result);
    }

    public function testItRetriesTheSetNumberOfTimesAsync(): void
    {
        $this->expectException(TooManyRetriesException::class);

        await(Retrier::retryAsync(3, function () {
            return PromiseFake::reject(new Exception('Oh no, it went wrong :('));
        }));
    }

    public function testItIndicatesWhatAttemptItIsOn(): void
    {
        $attempts = [];

        try {
            await(Retrier::retryAsync(3, function (int $attempt) use (&$attempts) {
                $attempts[] = $attempt;
                return PromiseFake::reject(new Exception('Sad times'));
            }));
        } catch (TooManyRetriesException) {
        }

        $this->assertEquals(range(0, 2), $attempts);
    }
}
