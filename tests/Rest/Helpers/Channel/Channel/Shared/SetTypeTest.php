<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException;

class SetTypeTest extends TestCase
{
    private function getClass(): DummyTraitTester
    {
        return new class () extends DummyTraitTester {
            use SetType;
        };
    }

    public function testSetType(): void
    {
        $class = $this->getClass();
        $class->setType(ChannelTypes::GUILD_TEXT);
        $this->assertEquals(['type' => ChannelTypes::GUILD_TEXT->value], $class->get());
        $this->assertEquals(ChannelTypes::GUILD_TEXT, $class->getType());
    }

    public function testSetTypeUnsupportedConversionException(): void
    {
        $class = $this->getClass();
        $this->expectException(
            UnsupportedConversionException::class
        );
        $class->setType(ChannelTypes::GUILD_VOICE);
    }
}
