<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\ThreadMember;

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

    /**
     * @var Channel[]
     */
    public array $threads;

    /**
     * @var ThreadMember[]
     */
    public array $members;
}
