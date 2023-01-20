<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-members-chunk
 */
class GuildMembersChunk
{
    public string $guild_id;
    public array $members; // @TODO
    public int $chunk_index;
    public int $chunk_count;
    public array $not_found;
    public array $presences; // @TODO
    public string $nonce;
}
