<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-stickers-update
 */
class GuildStickersUpdate
{
    public string $guild_id;

    /**
     * @var \Exan\Fenrir\Parts\Sticker[]
     */
    public array $stickers;
}
