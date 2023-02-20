<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-member-update
 */
class ThreadMembersUpdate extends ThreadMember
{
    public ?string $guild_id;
}
