<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * Requires GUILD_MEMBERS intent
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-members-update
 */
class ThreadMemberUpdate
{
    public string $id;
    public ?string $guild_id;
    public int $member_count;

    /**
     * @var \Exan\Dhp\Parts\ThreadMember[]
     */
    public ?array $added_members;

    /**
     * @var string[]
     */
    public ?array $removed_member_ids;
}
