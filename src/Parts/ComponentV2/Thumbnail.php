<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Parts\UnfurledMediaItem;

/**
 * @see https://docs.discord.com/developers/components/reference#thumbnail
 */
class Thumbnail extends Component
{
    public UnfurledMediaItem $media;
    public ?string $description;
    public ?bool $spoiler;
}
