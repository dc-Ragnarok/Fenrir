<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Exan\Retrier\Retrier;
use React\Promise\ExtendedPromiseInterface;

class RetrierFake extends Retrier
{
    public function retry(int $attempts, callable $action): ExtendedPromiseInterface
    {
        return PromiseFake::get($action(1));
    }
}
