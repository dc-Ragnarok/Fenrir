<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#invite-delete
 */
#[RequiresIntent(Intent::GUILD_INVITES)]
class InviteDelete
{
    public string $channel_id;
    public ?string $guild_id;
    public string $code;
}
