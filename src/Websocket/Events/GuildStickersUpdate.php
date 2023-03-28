<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-stickers-update
 */
class GuildStickersUpdate
{
    public string $guild_id;

    /**
     * @var \Ragnarok\Fenrir\Parts\Sticker[]
     */
    public array $stickers;
}
