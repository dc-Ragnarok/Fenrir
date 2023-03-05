<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use PHPUnit\Framework\TestCase;

class SetParentIdTest extends TestCase
{
    public function testSetParentId()
    {
        $class = new class extends DummyTraitTester {
            use SetParentId;
        };

        $class->setParentId('::parent id::');

        $this->assertEquals(['parent_id' => '::parent id::'], $class->get());
    }
}
