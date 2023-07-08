<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-emojis-update
 */
#[RequiresIntent(Intent::GUILD_EMOJIS_AND_STICKERS)]
class GuildEmojisUpdate
{
    public string $guild_id;

    /**
     * @var \Ragnarok\Fenrir\Parts\Emoji[]
     */
    public array $emojis;
}
