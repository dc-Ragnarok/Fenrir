<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;
use PHPUnit\Framework\TestCase;
use Exan\Fenrir\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException;

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
        $class->setType(ChannelTypes::GUILD_TEXT);
        $this->assertEquals(['type' => ChannelTypes::GUILD_TEXT->value], $class->get());
        $this->assertEquals(ChannelTypes::GUILD_TEXT, $class->getType());
    }

    public function testSetTypeUnsupportedConversionException()
    {
        $class = $this->getClass();
        $this->expectException(
            UnsupportedConversionException::class
        );
        $class->setType(ChannelTypes::GUILD_VOICE);
    }
}
