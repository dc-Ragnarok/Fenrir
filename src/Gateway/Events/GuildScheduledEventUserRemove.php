<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-scheduled-event-user-remove
 */
class GuildScheduledEventUserRemove
{
    public string $guild_scheduled_event_id;
    public string $user_id;
    public string $guild_id;
}
