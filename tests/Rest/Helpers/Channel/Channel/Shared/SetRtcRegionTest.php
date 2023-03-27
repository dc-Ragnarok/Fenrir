<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;
use PHPUnit\Framework\TestCase;

class SetRtcRegionTest extends TestCase
{
    public function testSetRtcRegion()
    {
        $class = new class extends DummyTraitTester {
            use SetRtcRegion;
        };

        $class->setRtcRegion('::rtc region::');

        $this->assertEquals(['rtc_region' => '::rtc region::'], $class->get());
        $this->assertEquals('::rtc region::', $class->getRtcRegion());
    }
}
