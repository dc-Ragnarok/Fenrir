<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-integrations-update
 */
#[RequiresIntent(Intent::GUILD_INTEGRATIONS)]
class GuildIntegrationsUpdate
{
    public string $guild_id;
}
