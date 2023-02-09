<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\StickerTypes;
use Exan\Dhp\Enums\Parts\StickerFormatTypes;

class Sticker
{
    public string $id;
    public ?string $pack_id;
    public string $name;
    public ?string $description;
    /** @var ?\Exan\Dhp\Parts\string[] */
    public ?array $tags;
    public ?string $asset;
    public StickerTypes $type;
    public StickerFormatTypes $format_type;
    public bool $available;
    public ?string $guild_id;
    public ?User $user;
    public ?int $sort_value;
}
