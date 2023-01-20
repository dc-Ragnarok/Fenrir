<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-ban-remove
 */
class GuildBanRemove
{
    public string $guild_id;
    public User $user;
}
