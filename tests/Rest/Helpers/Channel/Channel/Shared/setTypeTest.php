<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelType;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetType;
use PHPUnit\Framework\TestCase;

class SetTypeTest extends TestCase
{
    private function getClass()
    {
        return new class extends DummyTraitTester {
            use SetType;
        };
    }

    public function testSetType()
    {
        $class = $this->getClass();
        $class->setType(ChannelType::GUILD_TEXT);
        $this->assertEquals(['type' => ChannelType::GUILD_TEXT->value], $class->get());
    }

    public function testSetTypeUnsupportedConversionException()
    {
        $class = $this->getClass();
        $this->expectException(
            \Exan\Dhp\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException::class
        );
        $class->setType(ChannelType::GUILD_VOICE);
    }
}
