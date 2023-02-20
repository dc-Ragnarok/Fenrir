<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Emoji;

use Exan\Finrir\Parts\Emoji;

class EmojiBuilder
{
    private $data = [];

    public function setName(string $name): EmojiBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setAnimated(bool $animated): EmojiBuilder
    {
        $this->data['animated'] = $animated;

        return $this;
    }

    public function setId(string $id): EmojiBuilder
    {
        $this->data['id'] = $id;

        return $this;
    }

    public static function fromPart(Emoji $emoji): EmojiBuilder
    {
        $builder = new EmojiBuilder();

        if (isset($emoji->animated)) {
            $builder->setAnimated($emoji->animated);
        }

        if (isset($emoji->name)) {
            $builder->setName($emoji->name);
        }

        if (isset($emoji->id)) {
            $builder->setId($emoji->id);
        }

        return $builder;
    }

    public function get(): array
    {
        return $this->data;
    }

    public function __toString(): string
    {
        return isset($this->data['name'])
            ? $this->data['name'] . ':' . $this->data['id']
            : urlencode($this->data['id']);
    }
}
