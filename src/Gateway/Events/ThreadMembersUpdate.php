<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-member-update
 */
#[RequiresIntent(Intent::GUILDS)]
class ThreadMembersUpdate extends ThreadMember
{
    public ?string $guild_id;
}
