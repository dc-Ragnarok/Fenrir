<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-create
 */
class GuildCreate extends Guild
{
}
