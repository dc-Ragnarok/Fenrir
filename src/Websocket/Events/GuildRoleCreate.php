<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Role;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-role-create
 */
class GuildRoleCreate
{
    public string $guild_id;
    public Role $role;
}
