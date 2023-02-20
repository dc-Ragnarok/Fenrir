<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Integration;
use Exan\Finrir\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-integrations-update
 */
class IntegrationUpdate extends Integration
{
    use WithGuildId;
}
