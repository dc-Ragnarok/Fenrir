<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\Presence;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-members-chunk
 */
class GuildMembersChunk
{
    public string $guild_id;

    /**
     * @var GuildMember[]
     */
    #[ArrayMapping(GuildMember::class)]
    public array $members;

    public int $chunk_index;
    public int $chunk_count;
    public array $not_found;

    /**
     * @var Presence[]
     */
    #[ArrayMapping(Presence::class)]
    public array $presences;

    public string $nonce;
}
