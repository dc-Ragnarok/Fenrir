<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-emojis-update
 */
class GuildEmojisUpdate
{
    public string $guild_id;

    /**
     * @var \Exan\Dhp\Parts\Emoji[]
     */
    public array $emojis;
}
