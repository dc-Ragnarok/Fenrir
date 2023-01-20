<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-update
 */
class ThreadUpdate
{
    public ?string $guild_id;

    /**
     * @var string[]
     */
    public array $channel_ids;

    public array $threads; // @TODO
    public array $members; // @TODO
}
