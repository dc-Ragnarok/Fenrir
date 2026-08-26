<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\AuditLogEntry;

/**
 * @see https://discord.com/developers/docs/events/gateway-events#guild-audit-log-entry-create
 */
#[RequiresIntent(Intent::GUILD_MODERATION)]
class GuildAuditLogEntryCreate extends AuditLogEntry
{
    public string $guild_id;
}
