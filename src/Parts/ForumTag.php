<?php

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/channel#forum-tag-object
 */
class ForumTag
{
    public string $id;
    public string $name;
    public bool $moderated;
    public ?string $emoji_id;
    public ?string $emoji_name;
}
