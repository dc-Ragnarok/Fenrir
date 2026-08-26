<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;

/**
 * A grid of up to ten images or videos.
 *
 * @see https://discord.com/developers/docs/components/reference#media-gallery
 */
class MediaGallery extends Component
{
    public const MAX_ITEMS = 10;

    /** @var MediaGalleryItem[] */
    private array $items = [];

    public function __construct(private readonly ?int $id = null)
    {
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(MediaGalleryItem $item): self
    {
        if (count($this->items) === self::MAX_ITEMS) {
            throw new TooManyItemsException(
                'A media gallery can hold at most ' . self::MAX_ITEMS . ' items'
            );
        }

        $this->items[] = $item;

        return $this;
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::MEDIA_GALLERY->value,
            'items' => array_map(static fn (MediaGalleryItem $item) => $item->get(), $this->items),
        ];

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
