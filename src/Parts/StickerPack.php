<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class StickerPack
{
    public string $id;
    /**
     * @var Sticker[]
     */
    public array $stickers;
    public string $name;
    public string $sku_id;
    public ?string $cover_sticker_id;
    public string $description;
    public ?string $banner_asset_id;
}
