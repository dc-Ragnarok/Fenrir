<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Buffer;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Buffer\ZlibStream;

class ZlibStreamTest extends TestCase
{
    private const SUFFIX = "\x00\x00\xff\xff";

    private function compress(string $payload): string
    {
        return zlib_encode($payload, ZLIB_ENCODING_DEFLATE) . self::SUFFIX;
    }

    public function testItInflatesACompleteMessage(): void
    {
        $buffer = new ZlibStream();

        $messages = [];
        $buffer->onCompleteMessage(function (string $message) use (&$messages) {
            $messages[] = $message;
        });

        $payload = json_encode(['op' => 1, 'd' => 'hello']);

        $compressed = $this->compress($payload);

        $buffer->partialMessage($compressed);

        $this->assertCount(1, $messages);
        $this->assertSame($payload, $messages[0]);
    }

    public function testItHandlesChunkedMessages(): void
    {
        $buffer = new ZlibStream();

        $messages = [];
        $buffer->onCompleteMessage(function (string $message) use (&$messages) {
            $messages[] = $message;
        });

        $payload = json_encode(['op' => 2, 'd' => 'chunked']);
        $compressed = $this->compress($payload);

        $chunks = str_split($compressed, 5);

        foreach ($chunks as $chunk) {
            $buffer->partialMessage($chunk);
        }

        $this->assertCount(1, $messages);
        $this->assertSame($payload, $messages[0]);
    }

    public function testResetClearsBufferState(): void
    {
        $buffer = new ZlibStream();

        $messages = [];
        $buffer->onCompleteMessage(function (string $message) use (&$messages) {
            $messages[] = $message;
        });

        $payload = json_encode(['op' => 3]);
        $compressed = $this->compress($payload);

        $half = intdiv(strlen($compressed), 2);

        $firstHalf = substr($compressed, 0, $half);
        $secondHalf = substr($compressed, $half);

        $buffer->partialMessage($firstHalf);

        $buffer->reset();

        $this->assertEmpty($messages);

        $buffer->partialMessage($firstHalf);
        $buffer->partialMessage($secondHalf);

        $this->assertCount(1, $messages);
        $this->assertSame($payload, $messages[0]);
    }

    public function testItReceivesSeveralMessages(): void
    {
        $buffer = new ZlibStream();

        $messages = [];
        $buffer->onCompleteMessage(function (string $message) use (&$messages) {
            $messages[] = $message;
        });

        $payloads = [
            json_encode(['op' => 1, 'd' => 'first']),
            json_encode(['op' => 2, 'd' => 'second']),
            json_encode(['op' => 3, 'd' => 'third']),
        ];

        $compressedMessages = array_map(fn ($p) => $this->compress($p), $payloads);

        foreach ($compressedMessages as $compressed) {
            $half = intdiv(strlen($compressed), 2);

            $firstHalf = substr($compressed, 0, $half);
            $secondHalf = substr($compressed, $half);

            $buffer->partialMessage($firstHalf);
            $buffer->partialMessage($secondHalf);
        }

        $this->assertCount(3, $messages);
        $this->assertSame($payloads, $messages);
    }
}
