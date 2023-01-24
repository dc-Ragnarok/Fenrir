<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Activity;
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

    /**
     * @var Activity[]
     */
    public array $activities;

    public ClientStatus $clientStatus;
}
