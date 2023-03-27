<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\GuildSticker;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class ModifyStickerBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): ModifyStickerBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setDescription(string $description): ModifyStickerBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function setTags(string $tags): ModifyStickerBuilder
    {
        $this->data['tags'] = $tags;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->data['tags'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
