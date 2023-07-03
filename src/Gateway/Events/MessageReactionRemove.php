<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\Emoji;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-remove
 */
#[RequiresIntent(Intent::GUILD_MESSAGE_REACTIONS)]
#[RequiresIntent(Intent::DIRECT_MESSAGE_REACTIONS)]
class MessageReactionRemove
{
    public string $user_id;
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
    public Emoji $emoji;
}
