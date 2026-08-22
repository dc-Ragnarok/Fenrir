<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/soundboard#soundboard-sound-object
 */
class SoundboardSound
{
    public string $name;
    public string $sound_id;
    public float $volume;
    public ?string $emoji_id;
    public ?string $emoji_name;
    public string $guild_id;
    public bool $available;
    public User $user;
}
