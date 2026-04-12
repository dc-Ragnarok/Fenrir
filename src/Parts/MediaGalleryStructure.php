<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://docs.discord.com/developers/components/reference#media-gallery-media-gallery-item-structure
 */
class MediaGalleryItem
{
    public UnfurledMediaItem $media;
    public ?string $description;
    public ?bool $spoiler;
}
