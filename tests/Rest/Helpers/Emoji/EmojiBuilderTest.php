<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Emoji;

use Exan\Dhp\Enums\ImageData;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use PHPUnit\Framework\TestCase;

class EmojiBuilderTest extends TestCase
{
    public function testSetName()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setName('::name::');
        $this->assertEquals(['name' => '::name::'], $emojiBuilder->get());
    }

    public function testSetRoles()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setRoles(['::role1::', '::role2::']);
        $this->assertEquals(['roles' => ['::role1::', '::role2::']], $emojiBuilder->get());
    }

    public function testSetImage()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setImage('::image::', ImageData::PNG);

        $this->assertEquals(['image' => 'data:image/png;base64,OjppbWFnZTo6'], $emojiBuilder->get());
    }
}
