<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Parts\StickerTypes;
use Ragnarok\Fenrir\Enums\Parts\StickerFormatTypes;

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
    public StickerTypes $type;
    public StickerFormatTypes $format_type;
    public bool $available;
    public ?string $guild_id;
    public ?User $user;
    public ?int $sort_value;

    public function setType(int $value): void
    {
        $this->type = StickerTypes::from($value);
    }

    public function setFormatType(int $value): void
    {
        $this->format_type = StickerFormatTypes::from($value);
    }
}
