<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Emoji;

use Exan\Dhp\Enums\ImageData;
use Exan\Dhp\Rest\Helpers\Emoji\CreateEmojiBuilder;
use PHPUnit\Framework\TestCase;

class CreateEmojiBuilderTest extends TestCase
{
    public function testSetName()
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setName('::name::');
        $this->assertEquals(['name' => '::name::'], $emojiBuilder->get());
    }

    public function testSetRoles()
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setRoles(['::role1::', '::role2::']);
        $this->assertEquals(['roles' => ['::role1::', '::role2::']], $emojiBuilder->get());
    }

    public function testSetImage()
    {
        $emojiBuilder = new CreateEmojiBuilder();
        $emojiBuilder->setImage('::image::', ImageData::PNG);

        $this->assertEquals(['image' => 'data:image/png;base64,OjppbWFnZTo6'], $emojiBuilder->get());
    }
}
