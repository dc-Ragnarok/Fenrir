<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Emoji;

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
