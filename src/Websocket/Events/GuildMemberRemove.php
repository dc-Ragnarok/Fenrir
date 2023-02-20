<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Attributes\Intent;
use Exan\Finrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-remove
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberRemove
{
    public string $guild_id;
    public User $user;
}
