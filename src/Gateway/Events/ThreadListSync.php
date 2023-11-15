<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\Channel;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-list-sync
 */
#[RequiresIntent(Intent::GUILDS)]
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
    #[ArrayMapping(Channel::class)]
    public array $threads;

    public array $members;
}
