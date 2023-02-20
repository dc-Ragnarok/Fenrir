<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-create
 */
class GuildCreate extends Guild
{
}
