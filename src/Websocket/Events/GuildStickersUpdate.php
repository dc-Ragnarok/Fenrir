<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-stickers-update
 */
class GuildStickersUpdate
{
    public string $guild_id;

    /**
     * @var \Exan\Finrir\Parts\Sticker[]
     */
    public array $stickers;
}
