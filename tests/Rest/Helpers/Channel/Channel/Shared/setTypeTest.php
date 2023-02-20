<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetType;
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
        $class->setType(ChannelTypes::GUILD_TEXT);
        $this->assertEquals(['type' => ChannelTypes::GUILD_TEXT->value], $class->get());
    }

    public function testSetTypeUnsupportedConversionException()
    {
        $class = $this->getClass();
        $this->expectException(
            \Exan\Finrir\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException::class
        );
        $class->setType(ChannelTypes::GUILD_VOICE);
    }
}
