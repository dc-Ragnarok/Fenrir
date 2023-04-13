<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Integration;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#integration-create
 */
class IntegrationCreate extends Integration
{
    public string $guild_id;
}
