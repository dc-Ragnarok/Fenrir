<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

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
     * @var \Exan\Finrir\Parts\Channel[]
     */
    public array $threads;

    public array $members;
}
