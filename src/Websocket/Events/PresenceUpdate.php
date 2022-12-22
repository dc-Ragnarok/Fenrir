<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\ClientStatus;
use Exan\Dhp\Parts\User;

/**
 * requires GUILD_PRESENCES intent
 * @see https://discord.com/developers/docs/topics/gateway-events#presence-update
 */
class PresenceUpdate
{
    public User $user;
    public string $guild_id;
    public string $status;
    public array $activities; // @todo
    public ClientStatus $clientStatus;
}
