<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/channel#default-reaction-object
 */
class DefaultReactionEmoji
{
    public ?string $emoji_id;
    public ?string $emoji_name;
}
