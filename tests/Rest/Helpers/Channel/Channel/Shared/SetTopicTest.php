<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use PHPUnit\Framework\TestCase;

class SetTopicTest extends TestCase
{
    public function testSetTopic()
    {
        $class = new class extends DummyTraitTester {
            use SetTopic;
        };

        $class->setTopic('::topic::');

        $this->assertEquals(['topic' => '::topic::'], $class->get());
    }
}
