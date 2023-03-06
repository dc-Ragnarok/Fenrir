<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Emoji;

use Exan\Fenrir\Enums\ImageData;
use Exan\Fenrir\Rest\Helpers\GetNew;

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
        return isset($this->data['name']) ? $this->data['name'] : null;
    }

    public function setRoles(array $roles): CreateEmojiBuilder
    {
        $this->data['roles'] = $roles;

        return $this;
    }

    /** @return ?string[] */
    public function getRoles(): ?array
    {
        return isset($this->data['roles']) ? $this->data['roles'] : null;
    }

    public function setImage(string $content, ImageData $imageData): CreateEmojiBuilder
    {
        $this->data['image'] = 'data:' . $imageData->value . ';base64,' . base64_encode($content);

        return $this;
    }

    public function getImage(): ?string
    {
        return isset($this->data['image']) ? $this->data['image'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
