<?php

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#invite-delete
 */
class InviteDelete
{
    public string $channel_id;
    public ?string $guild_id;
    public string $code;
}
