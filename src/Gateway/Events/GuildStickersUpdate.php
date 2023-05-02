<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Sticker;

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
