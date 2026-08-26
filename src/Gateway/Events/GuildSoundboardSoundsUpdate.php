<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\SoundboardSound;

/**
 * @see https://discord.com/developers/docs/events/gateway-events#guild-soundboard-sounds-update
 */
#[RequiresIntent(Intent::GUILD_EMOJIS_AND_STICKERS)]
class GuildSoundboardSoundsUpdate
{
    /**
     * @var SoundboardSound[]
     */
    #[ArrayMapping(SoundboardSound::class)]
    public array $soundboard_sounds;
    public string $guild_id;
}
