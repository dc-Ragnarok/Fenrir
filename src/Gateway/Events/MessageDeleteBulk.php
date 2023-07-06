<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-delete-bulk
 */
#[RequiresIntent(Intent::GUILD_MESSAGES)]
class MessageDeleteBulk
{
    /**
     * @var string[]
     */
    public array $ids;

    public string $channel_id;
    public ?string $guild_id;
}
