<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Bitwise;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use PHPUnit\Framework\TestCase;

class BitwiseTest extends TestCase
{
    public function testAddAndGet(): void
    {
        $bitwise = new Bitwise();

        $bitwise->add(5 << 2);
        $bitwise->add(7 << 4);
        $bitwise->add(3 << 1);

        $result = $bitwise->get();

        $expected = (5 << 2) | (7 << 4) | (3 << 1);
        $this->assertEquals($expected, $result);
    }

    public function testHas(): void
    {
        $bitwise = new Bitwise();
        $bitwise->add(1 << 1);
        $bitwise->add(1 << 2);

        $this->assertTrue($bitwise->has(1 << 1));
        $this->assertFalse($bitwise->has(1 << 3));

        $bitwise->add(1 << 3);
        $this->assertTrue($bitwise->has(1 << 3));
    }

    public function testFrom(): void
    {
        $bitwise = Bitwise::from(1 << 1, 1 << 2);

        $this->assertTrue($bitwise->has(1 << 1));
        $this->assertTrue($bitwise->has(1 << 2));

        $this->assertFalse($bitwise->has(1 << 4));
    }

    public function testFromBitSet(): void
    {
        $bitwise = Bitwise::fromBitSet('010');

        $this->assertFalse($bitwise->has(1 << 2));
        $this->assertFalse($bitwise->has(1 << 0));

        $this->assertTrue($bitwise->has(1 << 1));
    }

    public function testGetBitSet(): void
    {
        $bitwise = Bitwise::from(
            1 << 0,
            1 << 2,
        );

        $this->assertEquals('101', $bitwise->getBitSet());
    }
}
