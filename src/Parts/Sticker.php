<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\StickerFormatType;
use Ragnarok\Fenrir\Enums\StickerType;

class Sticker
{
    public string $id;
    public ?string $pack_id;
    public string $name;
    public ?string $description;
    /**
     * @var string[]
     */
    public ?array $tags;
    public ?string $asset;
    public StickerType $type;
    public StickerFormatType $format_type;
    public bool $available;
    public ?string $guild_id;
    public ?User $user;
    public ?int $sort_value;

    public function setType(int $value): void
    {
        $this->type = StickerType::from($value);
    }

    public function setFormatType(int $value): void
    {
        $this->format_type = StickerFormatType::from($value);
    }
}
