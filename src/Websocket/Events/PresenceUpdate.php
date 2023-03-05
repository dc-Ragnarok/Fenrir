<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Attributes\Intent;
use Exan\Fenrir\Parts\ClientStatus;
use Exan\Fenrir\Parts\User;

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
     * @var \Exan\Fenrir\Parts\Activity[]
     */
    public array $activities;

    public ClientStatus $clientStatus;
}
