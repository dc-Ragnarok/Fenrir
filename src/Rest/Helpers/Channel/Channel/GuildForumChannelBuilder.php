<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel;

use Exan\Dhp\Enums\Parts\ChannelFlags;
use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Enums\Parts\ForumLayoutTypes;
use Exan\Dhp\Enums\Parts\SortOrderTypes;
use Exan\Dhp\Exceptions\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder\TooManyAvailableTagsException;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
class GuildForumChannelBuilder extends ChannelBuilder
{
    use SetTopic;
    use SetNsfw;
    use SetRateLimitPerUser;
    use SetParentId;
    use SetDefaultAutoArchiveDuration;
    use SetDefaultThreadRateLimitPerUser;

    public function __construct()
    {
        $this->setChannelType(ChannelTypes::GUILD_FORUM);
    }

    public function setFlags(ChannelFlags $flags)
    {
        $this->data['flags'] = $flags->value;
    }

    /**
     * Can not exceed 20 available tags
     *
     * @see https://discord.com/developers/docs/resources/channel#forum-tag-object
     *
     * @throws TooManyAvailableTagsException
     */
    public function addAvailableTag(
        string $name,
        ?bool $moderated = null,
        ?EmojiBuilder $emoji = null
    ): GuildForumChannelBuilder {
        if (!isset($this->data['available_tags'])) {
            $this->data['available_tags'] = [];
        } elseif (count($this->data['available_tags']) === 20) {
            throw new TooManyAvailableTagsException();
        }

        $tag = ['name' => $name];

        $this->data['available_tags'][] = &$tag;

        if (!is_null($moderated)) {
            $tag['moderated'] = $moderated;
        }

        if (!isset($emoji)) {
            return $this;
        }

        if (!is_null($emoji)) {
            $emojiData = $emoji->get();

            $add = isset($emojiData['name'])
                ? ['emoji_id' => $emojiData['id']]
                : ['emoji_name' => $emojiData['id']];

            $tag = array_merge($tag, $add);
        }


        return $this;
    }

    public function setDefaultReactionEmoji(EmojiBuilder $emoji): GuildForumChannelBuilder
    {
        $emojiData = $emoji->get();

        $this->data['default_reaction_emoji'] = isset($emojiData['name'])
            ? ['emoji_id' => $emojiData['id']]
            : ['emoji_name' => $emojiData['id']];

        return $this;
    }

    public function setDefaultSortOrder(SortOrderTypes $sortOrderType): GuildForumChannelBuilder
    {
        $this->data['default_sort_order'] = $sortOrderType->value;

        return $this;
    }

    public function setDefaultForumLayout(ForumLayoutTypes $formLayoutType): GuildForumChannelBuilder
    {
        $this->data['default_forum_layout'] = $formLayoutType->value;

        return $this;
    }
}
