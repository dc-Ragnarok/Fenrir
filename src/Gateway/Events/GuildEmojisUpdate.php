<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Emoji;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-emojis-update
 */
class GuildEmojisUpdate
{
    public string $guild_id;

    /**
     * @var Emoji[]
     */
    public array $emojis;
}
