<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\User;

/**
 * requires GUILD_MEMBERS intent
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-remove
 */
class GuildMemberRemove
{
    public string $guild_id;
    public User $user;
}
