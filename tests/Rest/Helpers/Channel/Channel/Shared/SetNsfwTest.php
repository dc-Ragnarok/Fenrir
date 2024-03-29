<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use PHPUnit\Framework\TestCase;

class SetNsfwTest extends TestCase
{
    public function testSetNsfw(): void
    {
        $class = new class () extends DummyTraitTester {
            use SetNsfw;
        };

        $class->setNsfw(true);

        $this->assertEquals(['nsfw' => true], $class->get());
        $this->assertTrue($class->getNsfw());

        $class->setNsfw(false);

        $this->assertEquals(['nsfw' => false], $class->get());
        $this->assertFalse($class->getNsfw());
    }
}
