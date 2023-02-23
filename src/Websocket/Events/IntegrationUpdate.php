<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Integration;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-integrations-update
 */
class IntegrationUpdate extends Integration
{
    public string $guild_id;
}
