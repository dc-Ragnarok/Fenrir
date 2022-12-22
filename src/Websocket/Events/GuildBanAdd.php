<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-ban-add
 */
class GuildBanAdd
{
    public string $guild_id;
    public User $user;
}
