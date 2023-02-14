<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
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

        $class->setNsfw(false);

        $this->assertEquals(['nsfw' => false], $class->get());
    }
}
