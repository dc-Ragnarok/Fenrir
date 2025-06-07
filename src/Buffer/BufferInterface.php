<?php

namespace Ragnarok\Fenrir\Buffer;

use Closure;

interface BufferInterface
{
    public function partialMessage(string $partial): void;
    public function onCompleteMessage(Closure $handler): void;
    public function additionalQueryData(): array;
    public function reset(): void;
}
