<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-update
 */
#[RequiresIntent(Intent::GUILDS)]
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
    #[ArrayMapping(Channel::class)]
    public array $threads;

    /**
     * @var ThreadMember[]
     */
    #[ArrayMapping(ThreadMember::class)]
    public array $members;
}
