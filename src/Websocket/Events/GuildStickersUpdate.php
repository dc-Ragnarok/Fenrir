<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Sticker;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-stickers-update
 */
class GuildStickersUpdate
{
    public string $guild_id;

    /**
     * @var Sticker[]
     */
    public array $stickers;
}
