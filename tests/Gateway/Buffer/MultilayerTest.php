<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Buffer;

use Closure;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Buffer\BufferInterface;
use Ragnarok\Fenrir\Buffer\Multilayer;

class MultilayerTest extends TestCase
{
    public function testItRoutesEventsThroughAllBuffersInOrder()
    {
        $result = null;

        $one = new class implements BufferInterface {
            private Closure $handler;

            public function partialMessage(string $partial): void
            {
                Assert::assertEquals('one', $partial);

                ($this->handler)('two');
            }

            public function onCompleteMessage(Closure $handler): void
            {
                $this->handler = $handler;
            }

            public function additionalQueryData(): array
            {
                return [];
            }
        };

        $two = new class implements BufferInterface {
            private Closure $handler;

            public function partialMessage(string $partial): void
            {
                Assert::assertEquals('two', $partial);

                ($this->handler)('three');
            }

            public function onCompleteMessage(Closure $handler): void
            {
                $this->handler = $handler;
            }

            public function additionalQueryData(): array
            {
                return [];
            }
        };

        $three = new class implements BufferInterface {
            private Closure $handler;

            public function partialMessage(string $partial): void
            {
                Assert::assertEquals('three', $partial);

                ($this->handler)('four');
            }

            public function onCompleteMessage(Closure $handler): void
            {
                $this->handler = $handler;
            }

            public function additionalQueryData(): array
            {
                return [];
            }
        };

        $four = new class implements BufferInterface {
            private Closure $handler;

            public function partialMessage(string $partial): void
            {
                Assert::assertEquals('four', $partial);

                ($this->handler)('five');
            }

            public function onCompleteMessage(Closure $handler): void
            {
                $this->handler = $handler;
            }

            public function additionalQueryData(): array
            {
                return [];
            }
        };

        $multilayer = new Multilayer([
            $one,
            $two,
            $three,
            $four
        ]);

        $multilayer->onCompleteMessage(function (string $message) use (&$result) {
            $result = $message;
        });

        $multilayer->partialMessage('one');
    }
}
