<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use PHPUnit\Framework\TestCase;

class SetBitRateTest extends TestCase
{
    public function testSetBitRate()
    {
        $class = new class extends DummyTraitTester {
            use SetBitrate;
        };

        $class->setBitrate(10000);

        $this->assertEquals(['bitrate' => 10000], $class->get());
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