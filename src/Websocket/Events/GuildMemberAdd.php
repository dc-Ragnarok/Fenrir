<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Member;
use Exan\Dhp\Parts\Traits\WithGuildId;

/**
 * requires GUILD_MEMBERS intent
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-add
 */
class GuildMemberAdd extends Member
{
    use WithGuildId;
}
