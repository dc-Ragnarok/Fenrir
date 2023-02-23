<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Message;
use Exan\Fenrir\Attributes\Intent;
use Exan\Fenrir\Parts\GuildMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[Intent("MESSAGE_CONTENT")]
class MessageCreate extends Message
{
    /**
     * @var \Exan\Fenrir\Parts\UserWithPartialMember[]
     */
    public array $mentions;
    public ?string $guild_id;
    public ?GuildMember $member;
}
