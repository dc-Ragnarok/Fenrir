<?php

declare(strict_types=1);

namespace Fakes\Exan\Fenrir;

use React\Promise\ExtendedPromiseInterface;
use React\Promise\Promise;

class PromiseFake
{
    /**
     * Returns a promise which resolves immediately
     *
     * @param mixed $return What the promise should resolve to
     */
    public static function get(mixed $return = null): ExtendedPromiseInterface
    {
        return new Promise(function ($resolve) use ($return) {
            $resolve($return);
        });
    }
}
