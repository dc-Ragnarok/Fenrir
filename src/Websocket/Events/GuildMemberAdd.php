<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Attributes\Intent;
use Exan\Finrir\Parts\GuildMember;
use Exan\Finrir\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberAdd extends GuildMember
{
    use WithGuildId;
}
