<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-ban-add
 */
class GuildBanAdd
{
    public string $guild_id;
    public User $user;
}
