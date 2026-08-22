<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\SoundboardSound;

/**
 * @see https://discord.com/developers/docs/events/gateway-events#guild-soundboard-sound-update
 */
#[RequiresIntent(Intent::GUILD_EMOJIS_AND_STICKERS)]
class GuildSoundboardSoundUpdate extends SoundboardSound
{
}
