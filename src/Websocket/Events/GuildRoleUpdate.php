<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Role;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-role-update
 */
class GuildRoleUpdate
{
    public string $guild_id;
    public Role $role;
}
