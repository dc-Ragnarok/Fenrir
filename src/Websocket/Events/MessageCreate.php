<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Message;
use Exan\Fenrir\Attributes\Intent;
use Exan\Fenrir\Enums\Gateway\Intents;
use Exan\Fenrir\Parts\GuildMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[Intent(Intents::MESSAGE_CONTENT, Intents::GUILD_MESSAGES, Intents::DIRECT_MESSAGES)]
class MessageCreate extends Message
{
    /**
     * @var \Exan\Fenrir\Parts\User[]
     */
    public array $mentions;
    public ?string $guild_id;
    public ?GuildMember $member;
}
