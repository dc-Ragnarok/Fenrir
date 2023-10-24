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
     * @var \Ragnarok\Fenrir\Enums\GuildFeature[]
     * @todo Enum array
     */
    public array $features;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?string $description;
    /**
     * @var \Ragnarok\Fenrir\Parts\Sticker[]
     */
    #[ArrayMapping(Sticker::class)]
    public ?array $stickers;
}
