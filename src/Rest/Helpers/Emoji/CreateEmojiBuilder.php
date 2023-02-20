<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Emoji;

use Exan\Fenrir\Enums\ImageData;

class CreateEmojiBuilder
{
    private $data = [];

    public function setName(string $name): CreateEmojiBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setRoles(array $roles): CreateEmojiBuilder
    {
        $this->data['roles'] = $roles;

        return $this;
    }

    public function setImage(string $content, ImageData $imageData): CreateEmojiBuilder
    {
        $this->data['image'] = 'data:' . $imageData->value . ';base64,' . base64_encode($content);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
