<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Channel;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-list-sync
 */
class ThreadListSync
{
    public string $guild_id;

    /**
     * @var string[]
     */
    public ?array $channel_ids;

    /**
     * @var Channel[]
     */
    public array $threads;

    public array $members;
}
