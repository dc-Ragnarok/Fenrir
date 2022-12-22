<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Emoji;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-remove
 */
class MessageReactionRemove
{
    public string $user_id;
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
    public Emoji $emoji;
}
