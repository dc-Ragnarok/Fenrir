<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-remove
 */
#[RequiresIntent(Intent::GUILD_MEMBERS)]
class GuildMemberRemove
{
    public string $guild_id;
    public User $user;
}
