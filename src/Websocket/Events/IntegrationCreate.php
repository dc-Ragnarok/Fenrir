<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Integration;
use Exan\Dhp\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#integration-create
 */
class IntegrationCreate extends Integration
{
    use WithGuildId;
}
