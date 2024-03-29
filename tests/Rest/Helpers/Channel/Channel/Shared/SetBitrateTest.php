<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use PHPUnit\Framework\TestCase;

class SetBitrateTest extends TestCase
{
    public function testSetBitRate(): void
    {
        $class = new class () extends DummyTraitTester {
            use SetBitrate;
        };

        $class->setBitrate(10000);

        $this->assertEquals(10000, $class->getBitrate());
    }

    public function testSetBitRateLowerThanMinimum(): void
    {
        $class = new class () extends DummyTraitTester {
            use SetBitrate;
        };

        $class->setBitrate(10);

        $this->assertEquals(['bitrate' => 8000], $class->get());
    }
}
