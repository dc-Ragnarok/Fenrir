<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\GuildMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
#[RequiresIntent(Intent::GUILD_MEMBERS)]
class GuildMemberAdd extends GuildMember
{
    public string $guild_id;
}
