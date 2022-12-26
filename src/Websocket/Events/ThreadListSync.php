<?php

namespace Exan\Dhp\Websocket\Events;

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
    public array $threads; // @TODO
    public array $members;
}
