<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Attributes\Intent;
use Ragnarok\Fenrir\Parts\GuildMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberAdd extends GuildMember
{
    public string $guild_id;
}
