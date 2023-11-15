<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\StickerFormatType;

class MessageStickerItem
{
    public string $id;
    public string $name;
    public StickerFormatType $format_type;
}
