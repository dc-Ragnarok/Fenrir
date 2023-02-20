<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Role;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-role-update
 */
class GuildRoleUpdate
{
    public string $guild_id;
    public Role $role;
}
