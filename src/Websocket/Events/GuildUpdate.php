<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-update
 */
class GuildUpdate extends Guild
{
}
