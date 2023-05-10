<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-integrations-update
 */
class GuildIntegrationsUpdate
{
    public string $guild_id;
}
