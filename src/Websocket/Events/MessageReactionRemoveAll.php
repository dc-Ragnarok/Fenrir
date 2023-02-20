<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-remove-all
 */
class MessageReactionRemoveAll
{
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
}
