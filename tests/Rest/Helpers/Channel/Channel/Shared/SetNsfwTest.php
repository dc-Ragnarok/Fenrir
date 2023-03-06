<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use PHPUnit\Framework\TestCase;

class SetNsfwTest extends TestCase
{
    public function testSetNsfw()
    {
        $class = new class extends DummyTraitTester {
            use SetNsfw;
        };

        $class->setNsfw(true);

        $this->assertEquals(['nsfw' => true], $class->get());
        $this->assertEquals(true, $class->getNsfw());

        $class->setNsfw(false);

        $this->assertEquals(['nsfw' => false], $class->get());
        $this->assertEquals(false, $class->getNsfw());
    }
}
