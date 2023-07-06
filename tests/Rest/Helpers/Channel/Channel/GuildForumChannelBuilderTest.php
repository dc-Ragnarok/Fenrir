<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ChannelFlag;
use Ragnarok\Fenrir\Enums\ChannelTypes;
use Ragnarok\Fenrir\Enums\ForumLayoutType;
use Ragnarok\Fenrir\Enums\SortOrderType;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder\TooManyAvailableTagsException;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;

class GuildForumChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildForumChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_FORUM->value
        ], $channelBuilder->get());
    }

    public function testSetFlags(): void
    {
        $builder = new GuildForumChannelBuilder();
        $builder->addFlag(ChannelFlag::PINNED);
        $bitwise = Bitwise::from(ChannelFlag::PINNED);

        $this->assertEquals($bitwise->get(), $builder->get()['flags']);
    }

    public function testAddAvailableTag(): void
    {
        $builder = new GuildForumChannelBuilder();
        $builder->addAvailableTag(
            '::tag::',
            true,
            (new EmojiBuilder())->setId('::id::')->setName('emoji')->setAnimated(false) // Guild emoji
        );

        $builder->addAvailableTag(
            '::tag::',
            true,
            (new EmojiBuilder())->setId('::name::') // Global/default emoji
        );

        $this->assertEquals([
            'name' => '::tag::',
            'moderated' => true,
            'emoji_id' => '::id::'
        ], $builder->get()['available_tags'][0]);

        $this->assertEquals([
            'name' => '::tag::',
            'moderated' => true,
            'emoji_name' => '::name::'
        ], $builder->get()['available_tags'][1]);
    }

    public function testAddTooManyAvailableTags(): void
    {
        $builder = new GuildForumChannelBuilder();

        foreach (range(1, 20) as $i) {
            $builder->addAvailableTag('::tag::');
        }
        $this->expectException(TooManyAvailableTagsException::class);
        $builder->addAvailableTag('::tag::');
    }

    public function testSetDefaultReactionEmoji(): void
    {
        $builder = new GuildForumChannelBuilder();
        $emoji = (new EmojiBuilder())->setId('::id::')->setName('emoji')->setAnimated(false); // Guild emoji
        $builder->setDefaultReactionEmoji($emoji);

        $this->assertEquals(['emoji_id' => '::id::'], $builder->get()['default_reaction_emoji']);

        $emoji = (new EmojiBuilder())->setId('::name::')->setAnimated(false); // Global/default emoji
        $builder->setDefaultReactionEmoji($emoji);

        $this->assertEquals(['emoji_name' => '::name::'], $builder->get()['default_reaction_emoji']);
    }

    public function testSetDefaultSortOrder(): void
    {
        $builder = new GuildForumChannelBuilder();
        $builder->setDefaultSortOrder(SortOrderType::LATEST_ACTIVITY);

        $this->assertEquals(SortOrderType::LATEST_ACTIVITY->value, $builder->get()['default_sort_order']);
    }

    public function testSetDefaultForumLayout(): void
    {
        $builder = new GuildForumChannelBuilder();
        $builder->setDefaultForumLayout(ForumLayoutType::NOT_SET);

        $this->assertEquals(ForumLayoutType::NOT_SET->value, $builder->get()['default_forum_layout']);
    }
}
