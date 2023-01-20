<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Emoji;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-remove-emoji
 */
class MessageReactionRemoveEmoji
{
    public string $channel_id;
    public ?string $guild_id;
    public string $message_id;
    public Emoji $emoji;
}
