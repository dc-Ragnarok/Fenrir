<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use PHPUnit\Framework\TestCase;

class SetTopicTest extends TestCase
{
    public function testSetTopic(): void
    {
        $class = new class () extends DummyTraitTester {
            use SetTopic;
        };

        $class->setTopic('::topic::');

        $this->assertEquals(['topic' => '::topic::'], $class->get());
        $this->assertEquals('::topic::', $class->getTopic());
    }
}
