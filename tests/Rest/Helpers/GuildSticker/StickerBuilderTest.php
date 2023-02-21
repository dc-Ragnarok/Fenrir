<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\GuildSticker;

use Exan\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use PHPUnit\Framework\TestCase;

class StickerBuilderTest extends TestCase
{
    public function testSetFile()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::binary data::', 'png');

        // Should include raw image data
        $this->assertStringContainsString('::binary data::', $stickerBuilder->get()->getBody());

        // Should include filename with provided extension
        $this->assertStringContainsString('filename="sticker.png"', $stickerBuilder->get()->getBody());

        // Should include correct header type
        $this->assertStringContainsString('Content-Type: image/png', $stickerBuilder->get()->getBody());
    }

    public function testSetName()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setName('::name::');

        $this->assertStringContainsString('"name":"::name::"', $stickerBuilder->get()->getBody());
    }

    public function testSetDescription()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setDescription('::description::');

        $this->assertStringContainsString('"description":"::description::"', $stickerBuilder->get()->getBody());
    }

    public function testSetTags()
    {
        $stickerBuilder = new StickerBuilder();
        $stickerBuilder->setFile('::file::', 'png');
        $stickerBuilder->setTags('::tags::');

        $this->assertStringContainsString('"tags":"::tags::"', $stickerBuilder->get()->getBody());
    }
}
