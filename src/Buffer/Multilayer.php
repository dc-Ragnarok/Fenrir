<?php

namespace Ragnarok\Fenrir\Buffer;

use Closure;

class Multilayer implements BufferInterface
{
    private Closure $handler;

    private BufferInterface $first;

    /** @param BufferInterface[] $buffers */
    public function __construct(public readonly array $buffers)
    {
        $this->handler = fn () => null;

        $keys = array_keys($buffers);

        foreach ($keys as $key => $bufferKey) {
            $buffer = $this->buffers[$bufferKey];

            if (isset($keys[$key + 1])) {
                $next = $this->buffers[$keys[$key + 1]];
                $buffer->onCompleteMessage(fn (string $message) => $next->partialMessage($message));

                continue;
            }

            $buffer->onCompleteMessage(fn (string $message) => ($this->handler)($message));
        }

        $this->first = $this->buffers[$keys[0]];
    }

    public function partialMessage(string $partial): void
    {
        $this->first->partialMessage($partial);
    }

    public function onCompleteMessage(Closure $handler): void
    {
        $this->handler = $handler;
    }

    public function additionalQueryData(): array
    {
        return array_merge(
            array_map(fn (BufferInterface $buffer) => $buffer->additionalQueryData(), $this->buffers)
        );
    }
}
