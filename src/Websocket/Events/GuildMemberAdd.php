<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Attributes\Intent;
use Exan\Dhp\Parts\GuildMember;
use Exan\Dhp\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
#[Intent("GUILD_MEMBERS")]
class GuildMemberAdd extends GuildMember
{
    use WithGuildId;
}
