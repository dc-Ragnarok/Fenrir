<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Bitwise\Bitwise;

/**
 * @see https://docs.discord.com/developers/components/reference#unfurled-media-item
 */
class UnfurledMediaItem
{
    public string $url;
    public ?string $proxy_url;
    public ?int $height;
    public ?int $width;
    public ?string $placeholder;
    public ?int $placeholder_version;
    public ?string $content_type;
    public ?Bitwise $flags;
    public ?string $attachment_id;
}
