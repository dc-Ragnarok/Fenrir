<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Emoji;

use Exan\Dhp\Enums\ImageData;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder as EmojiEmojiBuilder;

class EmojiBuilder
{
    private $data = [];

    public function setName(string $name): EmojiBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setRoles(array $roles): EmojiBuilder
    {
        $this->data['roles'] = $roles;

        return $this;
    }

    public function setImage(string $content, ImageData $imageData): EmojiEmojiBuilder
    {
        $this->data['image'] = 'data:' . $imageData->value . ';base64,' . base64_encode($content);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
