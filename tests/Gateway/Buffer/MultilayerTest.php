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
        $resets = [];

        $one = new class($resets) implements BufferInterface {
            private Closure $handler;

            public function __construct(private array &$resets)
            {
            }

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

            public function reset(): void
            {
                $this->resets[] = 1;
            }
        };

        $two = new class($resets) implements BufferInterface {
            private Closure $handler;

            public function __construct(private array &$resets)
            {

            }

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

            public function reset(): void
            {
                $this->resets[] = 2;
            }
        };

        $three = new class($resets) implements BufferInterface {
            private Closure $handler;

            public function __construct(private array &$resets)
            {

            }

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

            public function reset(): void
            {
                $this->resets[] = 3;
            }
        };

        $four = new class($resets) implements BufferInterface {
            private Closure $handler;

            public function __construct(private array &$resets)
            {

            }

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

            public function reset(): void
            {
                $this->resets[] = 4;
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

        $this->assertEquals('five', $result);

        $multilayer->reset();

        $this->assertEquals([1,2,3,4], $resets);
    }
}
