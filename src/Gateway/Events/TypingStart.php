<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\GuildMember;

/**
 * Note: this event is sent every 5 seconds while a user is typing. It is not
 * an accurate indicator of when the user is actively typing.
 *
 * @see https://discord.com/developers/docs/topics/gateway-events#typing-start
 */
#[RequiresIntent(Intent::GUILD_MESSAGE_TYPING)]
#[RequiresIntent(Intent::DIRECT_MESSAGE_TYPING)]
class TypingStart
{
    public string $channel_id;
    public ?string $guild_id;
    public string $user_id;
    public Carbon $timestamp;
    public ?GuildMember $member;
}
