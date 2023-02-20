<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Attributes\Intent;
use Exan\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-remove
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberRemove
{
    public string $guild_id;
    public User $user;
}
