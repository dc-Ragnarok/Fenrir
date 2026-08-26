<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\SoundboardSound;

/**
 * Sent in response to a request for a guild's soundboard sounds over the
 * gateway, rather than under an intent.
 *
 * @see https://discord.com/developers/docs/events/gateway-events#soundboard-sounds
 */
class SoundboardSounds
{
    /**
     * @var SoundboardSound[]
     */
    #[ArrayMapping(SoundboardSound::class)]
    public array $soundboard_sounds;
    public string $guild_id;
}
