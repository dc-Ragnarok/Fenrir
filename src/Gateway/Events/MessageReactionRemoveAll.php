<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-remove-all
 */
#[RequiresIntent(Intent::GUILD_MESSAGE_REACTIONS)]
#[RequiresIntent(Intent::DIRECT_MESSAGE_REACTIONS)]
class MessageReactionRemoveAll
{
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
}
