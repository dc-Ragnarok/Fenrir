<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use PHPUnit\Framework\TestCase;

class SetDefaultAutoArchiveDurationTest extends TestCase
{
    public function testSetArchiveDuration(): void
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultAutoArchiveDuration;
        };

        $class->setDefaultAutoArchiveDuration(10);

        $this->assertEquals(['default_auto_archive_duration' => 10], $class->get());
        $this->assertEquals(10, $class->getDefaultAutoArchiveDuration());
    }
}
