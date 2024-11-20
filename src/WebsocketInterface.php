<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Evenement\EventEmitterInterface;
use JsonSerializable;
use React\Promise\PromiseInterface;

interface WebsocketInterface extends EventEmitterInterface
{
    public function open(string $url): PromiseInterface;
    public function close(int $code, string $reason): void;
    public function send(string $message, bool $useBucket = true): void;
    public function sendAsJson(array|JsonSerializable $item, bool $useBucket): void;
}
