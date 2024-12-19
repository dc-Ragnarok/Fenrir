<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use React\Promise\PromiseInterface;
use React\Promise\Promise;
use Throwable;

class PromiseFake
{
    /**
     * Returns a promise which resolves immediately
     *
     * @param mixed $return What the promise should resolve to
     */
    public static function get(mixed $return = null): PromiseInterface
    {
        return new Promise(static function ($resolve) use ($return) {
            $resolve($return);
        });
    }

    /**
     * Returns a promise which rejects immediately
     *
     * @param Throwable $e The exception
     */
    public static function reject(Throwable $e): PromiseInterface
    {
        return new Promise(static function ($resolve, $reject) use ($e) {
            $reject($e);
        });
    }
}
