<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\GuildFeature;

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
     */
    public array $features;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?string $description;
    /**
     * @var \Ragnarok\Fenrir\Parts\Sticker[]
     */
    public ?array $stickers;

    public function setFeatures(array $value): void
    {
        $this->features = [];

        foreach ($value as $entry) {
            $this->features[] = GuildFeature::from($entry);
        }
    }
}
