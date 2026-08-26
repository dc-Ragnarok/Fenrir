<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * Discord wraps a guild's soundboard sounds in an object rather than returning
 * a bare array, unlike the default sounds endpoint.
 *
 * @see https://discord.com/developers/docs/resources/soundboard#list-guild-soundboard-sounds
 */
class GuildSoundboardSounds
{
    /**
     * @var SoundboardSound[]
     */
    #[ArrayMapping(SoundboardSound::class)]
    public array $items;
}
