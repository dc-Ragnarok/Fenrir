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
    public ?string $tags;
    public ?string $asset;
    public StickerType $type;
    public StickerFormatType $format_type;
    public bool $available;
    public ?string $guild_id;
    public ?User $user;
    public ?int $sort_value;
}
