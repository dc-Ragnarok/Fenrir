<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

/**
 * @see https://discord.com/developers/docs/components/reference#media-gallery-media-gallery-item-structure
 */
class MediaGalleryItem
{
    public function __construct(
        private readonly UnfurledMedia $media,
        private readonly ?string $description = null,
        private readonly ?bool $spoiler = null
    ) {
    }

    public function get(): array
    {
        $data = ['media' => $this->media->get()];

        if (!is_null($this->description)) {
            $data['description'] = $this->description;
        }

        if (!is_null($this->spoiler)) {
            $data['spoiler'] = $this->spoiler;
        }

        return $data;
    }
}
