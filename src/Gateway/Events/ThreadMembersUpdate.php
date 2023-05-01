<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-member-update
 */
class ThreadMembersUpdate extends ThreadMember
{
    public ?string $guild_id;
}
