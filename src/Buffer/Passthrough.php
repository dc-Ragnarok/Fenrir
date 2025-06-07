<?php

namespace Ragnarok\Fenrir\Buffer;

use Closure;

class Passthrough implements BufferInterface
{
    private Closure $completeHandler;

    public function __construct()
    {
        $this->completeHandler = fn () => null;
    }

    public function partialMessage(string $partial): void
    {
        ($this->completeHandler)($partial);
    }

    public function onCompleteMessage(Closure $handler): void
    {
        $this->completeHandler = $handler;
    }

    public function additionalQueryData(): array
    {
        return [];
    }

    public function reset(): void { }
}
