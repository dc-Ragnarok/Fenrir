<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/events/gateway-events#guild-soundboard-sound-delete
 */
#[RequiresIntent(Intent::GUILD_EMOJIS_AND_STICKERS)]
class GuildSoundboardSoundDelete
{
    public string $sound_id;
    public string $guild_id;
}
