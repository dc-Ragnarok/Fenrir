<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/poll#poll-media-object-poll-media-object-structure
 */
class PollMediaObject
{
    public ?string $text;
    public ?Emoji $emoji;
}
