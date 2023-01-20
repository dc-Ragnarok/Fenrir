<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-member-update
 */
class ThreadMembersUpdate extends ThreadMember
{
    public ?string $guild_id;
}
