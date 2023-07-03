<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-ban-remove
 */
#[RequiresIntent(Intent::GUILD_MODERATION)]
class GuildBanRemove
{
    public string $guild_id;
    public User $user;
}
