<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\ThreadMember;

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
     * @var ThreadMember[]
     */
    #[ArrayMapping(ThreadMember::class)]
    public ?array $added_members;

    /**
     * @var string[]
     */
    public ?array $removed_member_ids;
}
