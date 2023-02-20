<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Finrir\Bitwise\Bitwise;
use Exan\Finrir\Enums\Flags\ChannelFlags;
use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Enums\Parts\ForumLayoutTypes;
use Exan\Finrir\Enums\Parts\SortOrderTypes;
use Exan\Finrir\Exceptions\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder\TooManyAvailableTagsException;
use Exan\Finrir\Parts\Emoji;
use Exan\Finrir\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder;
use Exan\Finrir\Rest\Helpers\Emoji\EmojiBuilder;
use PHPUnit\Framework\TestCase;

class GuildForumChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildForumChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_FORUM->value
        ], $channelBuilder->get());
    }

    public function testSetFlags()
    {
        $builder = new GuildForumChannelBuilder();
        $builder->addFlag(ChannelFlags::PINNED);
        $bitwise = Bitwise::from(ChannelFlags::PINNED);

        $this->assertEquals($bitwise->get(), $builder->get()['flags']);
    }

    public function testAddAvailableTag()
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

    public function testAddTooManyAvailableTags()
    {
        $builder = new GuildForumChannelBuilder();

        foreach (range(1, 20) as $i) {
            $builder->addAvailableTag('::tag::');
        }
        $this->expectException(TooManyAvailableTagsException::class);
        $builder->addAvailableTag('::tag::');
    }

    public function testSetDefaultReactionEmoji()
    {
        $builder = new GuildForumChannelBuilder();
        $emoji = (new EmojiBuilder())->setId('::id::')->setName('emoji')->setAnimated(false); // Guild emoji
        $builder->setDefaultReactionEmoji($emoji);

        $this->assertEquals(['emoji_id' => '::id::'], $builder->get()['default_reaction_emoji']);

        $emoji = (new EmojiBuilder())->setId('::name::')->setAnimated(false); // Global/default emoji
        $builder->setDefaultReactionEmoji($emoji);

        $this->assertEquals(['emoji_name' => '::name::'], $builder->get()['default_reaction_emoji']);
    }

    public function testSetDefaultSortOrder()
    {
        $builder = new GuildForumChannelBuilder();
        $builder->setDefaultSortOrder(SortOrderTypes::LATEST_ACTIVITY);

        $this->assertEquals(SortOrderTypes::LATEST_ACTIVITY->value, $builder->get()['default_sort_order']);
    }

    public function testSetDefaultForumLayout()
    {
        $builder = new GuildForumChannelBuilder();
        $builder->setDefaultForumLayout(ForumLayoutTypes::NOT_SET);

        $this->assertEquals(ForumLayoutTypes::NOT_SET->value, $builder->get()['default_forum_layout']);
    }
}
