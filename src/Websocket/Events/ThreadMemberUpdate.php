<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-members-update
 */
#[Intent("GUILD_MEMBERS")]
class ThreadMemberUpdate
{
    public string $id;
    public ?string $guild_id;
    public int $member_count;

    /**
     * @var \Exan\Fenrir\Parts\ThreadMember[]
     */
    public ?array $added_members;

    /**
     * @var string[]
     */
    public ?array $removed_member_ids;
}
