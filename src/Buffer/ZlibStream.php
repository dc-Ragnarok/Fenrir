<?php

namespace Ragnarok\Fenrir\Buffer;

use Closure;
use InflateContext;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ZlibStream implements BufferInterface
{
    private Closure $completeHandler;

    private const SUFFIX = "\x00\x00\xff\xff";

    private string $buffer = '';

    private InflateContext $inflator;

    public function __construct(private readonly LoggerInterface $logger = new NullLogger())
    {
        $this->completeHandler = fn () => null;
        $this->inflator = inflate_init(ZLIB_ENCODING_DEFLATE);
    }

    public function reset(): void
    {
        $this->logger->debug('Resetting Buffer');

        $this->buffer = '';
        $this->inflator = inflate_init(ZLIB_ENCODING_DEFLATE);
    }

    public function partialMessage(string $partial): void
    {
        $this->buffer .= $partial;

        if (!str_ends_with($partial, self::SUFFIX)) {
            return;
        }

        $message = inflate_add($this->inflator, $this->buffer);
        $this->buffer = '';

        if ($message === false) {
            $this->logger->warning('Failed to decode zlib-stream message(s)');
            return;
        }

        ($this->completeHandler)($message);
    }

    public function onCompleteMessage(Closure $handler): void
    {
        $this->completeHandler = $handler;
    }

    public function additionalQueryData(): array
    {
        return [
            'compress' => 'zlib-stream',
        ];
    }
}
