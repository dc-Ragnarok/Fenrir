<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\StickerFormatTypes;

class MessageStickerItem
{
    public string $id;
    public string $name;
    public StickerFormatTypes $format_type;

    public function setFormatType(int $value): void
    {
        $this->format_type = StickerFormatTypes::from($value);
    }
}
