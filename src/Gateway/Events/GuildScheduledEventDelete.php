<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\GuildScheduledEvent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-scheduled-event-delete
 */
#[RequiresIntent(Intent::GUILD_SCHEDULED_EVENTS)]
class GuildScheduledEventDelete extends GuildScheduledEvent
{
}
