<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Attributes\Intent;
use Exan\Fenrir\Parts\GuildMember;
use Exan\Fenrir\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberAdd extends GuildMember
{
    use WithGuildId;
}
