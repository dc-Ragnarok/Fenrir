<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\GuildSticker;

class ModifyStickerBuilder
{
    private array $data = [];

    public function setName(string $name): ModifyStickerBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return isset($this->data['name']) ? $this->data['name'] : null;
    }

    public function setDescription(string $description): ModifyStickerBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return isset($this->data['description']) ? $this->data['description'] : null;
    }

    public function setTags(string $tags): ModifyStickerBuilder
    {
        $this->data['tags'] = $tags;

        return $this;
    }

    public function getTags(): ?string
    {
        return isset($this->data['tags']) ? $this->data['tags'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
