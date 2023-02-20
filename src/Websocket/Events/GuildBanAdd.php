<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-ban-add
 */
class GuildBanAdd
{
    public string $guild_id;
    public User $user;
}
