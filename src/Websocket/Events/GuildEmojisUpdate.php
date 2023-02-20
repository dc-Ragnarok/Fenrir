<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-emojis-update
 */
class GuildEmojisUpdate
{
    public string $guild_id;

    /**
     * @var \Exan\Finrir\Parts\Emoji[]
     */
    public array $emojis;
}
