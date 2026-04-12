<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\MediaGalleryItem;

/**
 * @see https://docs.discord.com/developers/components/reference#media-gallery
 */
class MediaGallery extends Component
{
    /**
     * @var MediaGalleryItem[]
     */
    #[ArrayMapping(MediaGalleryItem::class)]
    public array $items;
}
