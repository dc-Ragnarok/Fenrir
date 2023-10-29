<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\GuildFeature;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class GuildPreview
{
    public string $id;
    public string $name;
    public ?string $icon;
    public ?string $splash;
    public ?string $discovery_splash;
    public array $emojis;
    /**
     * @var GuildFeature[]
     */
    #[ArrayMapping(GuildFeature::class)]
    public array $features;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?string $description;
    /**
     * @var Sticker[]
     */
    #[ArrayMapping(Sticker::class)]
    public ?array $stickers;
}
