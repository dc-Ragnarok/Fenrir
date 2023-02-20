<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-members-chunk
 */
class GuildMembersChunk
{
    public string $guild_id;

    /**
     * @var \Exan\Fenrir\Parts\GuildMember[]
     */
    public array $members;

    public int $chunk_index;
    public int $chunk_count;
    public array $not_found;

    /**
     * @var \Exan\Fenrir\Parts\Presence[]
     */
    public array $presences;

    public string $nonce;
}
