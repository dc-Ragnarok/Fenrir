<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Attributes\Intent;
use Ragnarok\Fenrir\Enums\Gateway\Intents;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[Intent(Intents::MESSAGE_CONTENT, Intents::GUILD_MESSAGES, Intents::DIRECT_MESSAGES)]
class MessageCreate extends Message
{
    /**
     * @var User[]
     */
    public array $mentions;
    public ?string $guild_id;
    public ?GuildMember $member;
}
