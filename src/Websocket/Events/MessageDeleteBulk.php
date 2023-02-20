<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-delete-bulk
 */
class MessageDeleteBulk
{
    /**
     * @var string[]
     */
    public array $ids;

    public string $channel_id;
    public ?string $guild_id;
}
