<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[RequiresIntent(Intent::MESSAGE_CONTENT)]
#[RequiresIntent(Intent::GUILD_MESSAGES)]
#[RequiresIntent(Intent::DIRECT_MESSAGES)]
class MessageCreate extends Message
{
    /**
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public array $mentions;
    public ?string $guild_id;
    public ?GuildMember $member;
}
