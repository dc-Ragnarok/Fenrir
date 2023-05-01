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
        return new Promise(function (callable $resolve, callable $reject) use ($attempts, $action) {
            $retries = 0;
            $shouldReject = function () use (&$retries, $attempts) {
                return ++$retries >= $attempts;
            };

            $executeAction = function (
                callable $action
            ) use (
                $resolve,
                $shouldReject,
                $reject,
                &$executeAction,
                &$retries
            ) {
                $action($retries)
                    ->then($resolve)
                    ->otherwise(fn () => $shouldReject()
                        ? $reject(new TooManyRetriesException())
                        : $executeAction($action));
            };

            $executeAction($action);
        });
    }
}
