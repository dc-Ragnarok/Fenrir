<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-stickers-update
 */
class GuildStickersUpdate
{
    public string $guild_id;
    public array $stickers; // @TODO
}
