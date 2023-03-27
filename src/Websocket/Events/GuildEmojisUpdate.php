<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-emojis-update
 */
class GuildEmojisUpdate
{
    public string $guild_id;

    /**
     * @var \Ragnarok\Fenrir\Parts\Emoji[]
     */
    public array $emojis;
}
