<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Emoji;

use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class CreateEmojiBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): CreateEmojiBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setRoles(array $roles): CreateEmojiBuilder
    {
        $this->data['roles'] = $roles;

        return $this;
    }

    /** @return ?string[] */
    public function getRoles(): ?array
    {
        return $this->data['roles'] ?? null;
    }

    public function setImage(string $content, ImageData $imageData): CreateEmojiBuilder
    {
        $this->data['image'] = 'data:' . $imageData->value . ';base64,' . base64_encode($content);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->data['image'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
