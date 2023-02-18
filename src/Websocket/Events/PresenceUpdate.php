<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Attributes\Intent;
use Exan\Dhp\Parts\ClientStatus;
use Exan\Dhp\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#presence-update
 */
#[Intent("GUILD_PRESENCES")]
class PresenceUpdate
{
    public User $user;
    public string $guild_id;
    public string $status;

    /**
     * @var \Exan\Dhp\Parts\Activity[]
     */
    public array $activities;

    public ClientStatus $clientStatus;
}
