<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Emoji;
use Ragnarok\Fenrir\Parts\GuildMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-add
 */
class MessageReactionAdd
{
    public string $user_id;
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
    public ?GuildMember $member;
    public Emoji $emoji;
}
