<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\GuildSticker;

use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\ModifyStickerBuilder;
use PHPUnit\Framework\TestCase;

class ModifyStickerBuilderTest extends TestCase
{
    public function testSetName(): void
    {
        $modifyStickerBuilder = new ModifyStickerBuilder();
        $modifyStickerBuilder->setName('::name::');

        $this->assertEquals(['name' => '::name::'], $modifyStickerBuilder->get());
        $this->assertEquals('::name::', $modifyStickerBuilder->getName());
    }

    public function testSetDescription(): void
    {
        $modifyStickerBuilder = new ModifyStickerBuilder();
        $modifyStickerBuilder->setDescription('::description::');

        $this->assertEquals(['description' => '::description::'], $modifyStickerBuilder->get());
        $this->assertEquals('::description::', $modifyStickerBuilder->getDescription());
    }

    public function testSetTags(): void
    {
        $modifyStickerBuilder = new ModifyStickerBuilder();
        $modifyStickerBuilder->setTags('::tags::');

        $this->assertEquals(['tags' => '::tags::'], $modifyStickerBuilder->get());
        $this->assertEquals('::tags::', $modifyStickerBuilder->getTags());
    }
}
