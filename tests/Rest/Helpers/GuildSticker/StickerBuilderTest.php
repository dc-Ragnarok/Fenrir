<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\GuildSticker;

use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use PHPUnit\Framework\TestCase;

class StickerBuilderTest extends TestCase
{
    public function testSetFile()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::binary data::', 'png');

        $this->assertEquals([
            'content' => '::binary data::',
            'extension' => 'png',
            'content-type' => 'image/png'
        ], $stickerBuilder->getFile());

        // Should include raw image data
        $this->assertStringContainsString('::binary data::', (string) $stickerBuilder->get());

        // Should include filename with provided extension
        $this->assertStringContainsString('filename="sticker.png"', (string) $stickerBuilder->get());

        // Should include correct header type
        $this->assertStringContainsString('Content-Type: image/png', (string) $stickerBuilder->get());
    }

    public function testSetName()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setName('::name::');

        $this->assertStringContainsString('"name":"::name::"', (string) $stickerBuilder->get());
        $this->assertEquals('::name::', $stickerBuilder->getName());
    }

    public function testSetDescription()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setDescription('::description::');

        $this->assertStringContainsString('"description":"::description::"', (string) $stickerBuilder->get());
        $this->assertEquals('::description::', $stickerBuilder->getDescription());
    }

    public function testSetTags()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setTags('::tags::');

        $this->assertStringContainsString('"tags":"::tags::"', (string) $stickerBuilder->get());
        $this->assertEquals('::tags::', $stickerBuilder->getTags());
    }
}
