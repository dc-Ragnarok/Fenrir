<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Exceptions\Retrier\TooManyRetriesException;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\Promise;

class Retrier
{
    public static function retryAsync(
        int $attempts,
        callable $action
    ): ExtendedPromiseInterface {
        return new Promise(static function (callable $resolve, callable $reject) use ($attempts, $action) {
            $retries = 0;
            $shouldReject = static function () use (&$retries, $attempts) {
                return ++$retries >= $attempts;
            };

            $executeAction = static function (
                callable $action
            ) use (
                &$retries,
                $resolve,
                $shouldReject,
                $reject,
                &$executeAction
) {
                $action($retries)
                    ->then($resolve)
                    ->otherwise(static fn () => $shouldReject()
                        ? $reject(new TooManyRetriesException())
                        : $executeAction($action));
            };

            $executeAction($action);
        });
    }
}
