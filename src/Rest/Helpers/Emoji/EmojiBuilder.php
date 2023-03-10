<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Emoji;

use Exan\Fenrir\Parts\Emoji;
use Exan\Fenrir\Rest\Helpers\GetNew;

class EmojiBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): EmojiBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setAnimated(bool $animated): EmojiBuilder
    {
        $this->data['animated'] = $animated;

        return $this;
    }

    public function getAnimated(): ?bool
    {
        return $this->data['animated'] ?? null;
    }

    public function setId(string $id): EmojiBuilder
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->data['id'] ?? null;
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
