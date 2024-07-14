<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Evenement\EventEmitter;
use JsonSerializable;
use Ragnarok\Fenrir\WebsocketInterface;
use React\Promise\ExtendedPromiseInterface;

class WebsocketFake extends EventEmitter implements WebsocketInterface
{
    public array $openings = [];

    public function open(string $url): ExtendedPromiseInterface
    {
        $this->openings[] = $url;

        return PromiseFake::get();
    }

    public function close(int $code, string $reason): void
    {
    }

    public function send(string $message, bool $useBucket = true): void
    {
    }

    public function sendAsJson(array|JsonSerializable $item, bool $useBucket): void
    {
    }
}
