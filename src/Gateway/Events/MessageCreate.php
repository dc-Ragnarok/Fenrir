<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\Intent as RequiredIntents;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\Message;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[RequiredIntents(Intent::MESSAGE_CONTENT, Intent::GUILD_MESSAGES, Intent::DIRECT_MESSAGES)]
class MessageCreate extends Message
{
    /**
     * @var \Ragnarok\Fenrir\Parts\User[]
     */
    public array $mentions;
    public ?string $guild_id;
    public ?GuildMember $member;
}
