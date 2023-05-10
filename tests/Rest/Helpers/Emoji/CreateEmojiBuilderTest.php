<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Emoji;

use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\CreateEmojiBuilder;
use PHPUnit\Framework\TestCase;

class CreateEmojiBuilderTest extends TestCase
{
    public function testSetName(): void
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setName('::name::');
        $this->assertEquals(['name' => '::name::'], $emojiBuilder->get());
        $this->assertEquals('::name::', $emojiBuilder->getName());
    }

    public function testSetRoles(): void
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setRoles(['::role1::', '::role2::']);
        $this->assertEquals(['roles' => ['::role1::', '::role2::']], $emojiBuilder->get());
        $this->assertEquals(['::role1::', '::role2::'], $emojiBuilder->getRoles());
    }

    public function testSetImage(): void
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setImage('::image::', ImageData::PNG);

        $this->assertEquals(['image' => 'data:image/png;base64,OjppbWFnZTo6'], $emojiBuilder->get());
        $this->assertEquals('data:image/png;base64,OjppbWFnZTo6', $emojiBuilder->getImage());
    }
}
