<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-members-update
 */
#[RequiresIntent(Intent::GUILDS)]
class ThreadMemberUpdate
{
    public string $id;
    public ?string $guild_id;
    public int $member_count;

    /**
     * @var \Ragnarok\Fenrir\Parts\ThreadMember[]
     */
    public ?array $added_members;

    /**
     * @var string[]
     */
    public ?array $removed_member_ids;
}
