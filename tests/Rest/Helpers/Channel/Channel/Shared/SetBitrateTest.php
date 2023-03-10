<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use PHPUnit\Framework\TestCase;

class SetBitrateTest extends TestCase
{
    public function testSetBitRate()
    {
        $class = new class extends DummyTraitTester {
            use SetBitrate;
        };

        $class->setBitrate(10000);

        $this->assertEquals(10000, $class->getBitrate());
    }

    public function testSetBitRateLowerThanMinimum()
    {
        $class = new class extends DummyTraitTester {
            use SetBitrate;
        };

        $class->setBitrate(10);

        $this->assertEquals(['bitrate' => 8000], $class->get());
    }
}
