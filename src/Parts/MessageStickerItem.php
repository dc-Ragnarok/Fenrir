<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\StickerFormatType;

class MessageStickerItem
{
    public string $id;
    public string $name;
    public StickerFormatType $format_type;

    public function setFormatType(int $value): void
    {
        $this->format_type = StickerFormatType::from($value);
    }
}
