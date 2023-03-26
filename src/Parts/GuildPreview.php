<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\GuildFeatures;

class GuildPreview
{
    public string $id;
    public string $name;
    public ?string $icon;
    public ?string $splash;
    public ?string $discovery_splash;
    public array $emojis;
    /**
     * @var \Exan\Fenrir\Enums\Parts\GuildFeatures[]
     */
    public array $features;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?string $description;
    /**
     * @var \Exan\Fenrir\Parts\Sticker[]
     */
    public ?array $stickers;

    public function setFeatures(array $value): void
    {
        $this->features = [];

        foreach ($value as $entry) {
            $this->features[] = GuildFeatures::from($entry);
        }
    }
}
