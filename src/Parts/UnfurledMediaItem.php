<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\UnfurledMediaItemLoadingState;

class UnfurledMediaItem
{
    public string $url;
    public string $proxy_url;
    public ?int $width;
    public ?int $height;
    public ?string $placeholder;
    public ?int $placeholder_version;
    public ?string $content_type;
    public UnfurledMediaItemLoadingState $loading_state;
    public Bitwise $flags;
}
