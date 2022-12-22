<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Integration;
use Exan\Dhp\Parts\Traits\WithGuildId;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-integrations-update
 */
class IntegrationUpdate extends Integration
{
    use WithGuildId;
}
