<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Attributes\Intent;
use Exan\Dhp\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-remove
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberRemove
{
    public string $guild_id;
    public User $user;
}
