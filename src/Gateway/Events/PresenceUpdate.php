<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\ClientStatus;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#presence-update
 */
#[RequiresIntent(Intent::GUILD_PRESENCES)]
class PresenceUpdate
{
    public User $user;
    public string $guild_id;
    public string $status;

    /**
     * @var \Ragnarok\Fenrir\Parts\Activity[]
     */
    public array $activities;

    public ClientStatus $clientStatus;
}
