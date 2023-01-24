<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\StickerFormatType;

/**
 * @see https://discord.com/developers/docs/resources/sticker#sticker-object
 */
class Sticker
{
    public string $id;
    public ?string $pack_id;
    public string $name;
    public ?string $description;
    public string $tags;
    public ?string $asset;
    public StickerFormatType $type;
    public ?bool $available;
    public ?string $guild_id;
    public ?User $user;
    public ?int $sort_value;
}
