<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Attributes\Intent;
use Exan\Finrir\Parts\ClientStatus;
use Exan\Finrir\Parts\User;

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
     * @var \Exan\Finrir\Parts\Activity[]
     */
    public array $activities;

    public ClientStatus $clientStatus;
}
