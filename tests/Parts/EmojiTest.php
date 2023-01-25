<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Parts;

use Exan\Dhp\Parts\Emoji;
use PHPUnit\Framework\TestCase;

class EmojiTest extends TestCase
{
    public function testCreateEmojiFromId()
    {
        $stringEmoji = '✅';
        $emoji = Emoji::get($stringEmoji);

        $this->assertEquals(urlencode($stringEmoji), (string) $emoji);
    }

    public function testCreateEmojiFromIdAndName()
    {
        $emoji = Emoji::get('12345', 'name');

        $this->assertEquals('name:12345', (string) $emoji);
    }

    public function testPartialEmoji()
    {
        $emoji = Emoji::get('::id::', '::name::', true);

        $this->assertEquals([
            'id' => '::id::',
            'name' => '::name::',
            'animated' => true,
        ], $emoji->getPartial());
    }
}
