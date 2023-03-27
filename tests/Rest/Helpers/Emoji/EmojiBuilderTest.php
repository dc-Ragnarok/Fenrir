<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Emoji;

use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Parts\Emoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;
use PHPUnit\Framework\TestCase;

class EmojiBuilderTest extends TestCase
{
    public function testSetName()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setName('::name::');
        $this->assertEquals(['name' => '::name::'], $emojiBuilder->get());
        $this->assertEquals('::name::', $emojiBuilder->getName());
    }

    public function testSetId()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setId('::id::');
        $this->assertEquals(['id' => '::id::'], $emojiBuilder->get());
        $this->assertEquals('::id::', $emojiBuilder->getId());
    }

    public function testSetAnimated()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setAnimated(true);
        $this->assertEquals(['animated' => true], $emojiBuilder->get());
        $this->assertEquals(true, $emojiBuilder->getAnimated());
    }

    public function testCreateEmojiFromId()
    {
        $emojiBuilder = new EmojiBuilder();
        $stringEmoji = '✅';
        $emojiBuilder->setId($stringEmoji);

        $this->assertEquals(urlencode($stringEmoji), (string) $emojiBuilder);
    }

    public function testCreateEmojiFromIdAndName()
    {
        $emojiBuilder = new EmojiBuilder();
        $emojiBuilder->setName('name');
        $emojiBuilder->setId('12345');

        $this->assertEquals('name:12345', (string) $emojiBuilder);
    }

    /**
     * @dataProvider getFromPartProvider
     */
    public function testGetFromPart(Emoji $emoji, array $result)
    {
        $this->assertEquals(EmojiBuilder::fromPart($emoji)->get(), $result);
    }

    public function getFromPartProvider(): array
    {
        return [
            'All properties' => [
                'emoji' => (function () {
                    $emoji = new Emoji();

                    $emoji->id = '::id::';
                    $emoji->name = '::name::';
                    $emoji->animated = true;

                    return $emoji;
                })(),
                'result' => [
                    'id' => '::id::',
                    'name' => '::name::',
                    'animated' => true,
                ],
            ],
            'No properties' => [
                'emoji' => (function () {
                    $emoji = new Emoji();

                    return $emoji;
                })(),
                'result' => [],
            ],
        ];
    }
}
