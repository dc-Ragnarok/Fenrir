<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-role-delete
 */
#[RequiresIntent(Intent::GUILD_MEMBERS)]
class GuildRoleDelete
{
    public string $guild_id;
    public string $role_id;
}
