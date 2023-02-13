<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelFlags;
use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Enums\Parts\ForumLayoutTypes;
use Exan\Dhp\Enums\Parts\SortOrderTypes;
use Exan\Dhp\Exceptions\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder\TooManyAvailableTagsException;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
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
        $builder->setFlags(ChannelFlags::PINNED);

        $this->assertEquals(ChannelFlags::PINNED->value, $builder->get()['flags']);
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