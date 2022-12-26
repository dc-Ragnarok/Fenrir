<?php

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
    public ?array $added_members; // @TODO

    /**
     * @var string[]
     */
    public ?array $removed_member_ids;
}
