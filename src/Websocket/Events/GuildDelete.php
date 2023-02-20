<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-delete
 */
class GuildDelete extends Guild
{
}
