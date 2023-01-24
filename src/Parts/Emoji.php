<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/emoji#emoji-object
 * @todo
 */
class Emoji
{
    public string $id;
    public ?string $name;
    public ?array $roles;
    public ?User $user;
    public ?bool $require_colons;
    public ?bool $managed;
    public ?bool $animated;
    public ?bool $available;

    public function getPartial(): array
    {
        return [
            'id' => $this->id,
            'name' => isset($this->name) ? $this->name : null,
            'animated' => isset($this->animated),
        ];
    }

    public function __toString(): string
    {
        return isset($this->name)
            ? $this->name . ':' . $this->id
            : urlencode($this->id);
    }

    public static function get(string $id, string $name): self
    {
        $emoji = new self();
        $emoji->id = $id;
        $emoji->name = $name;

        return $emoji;
    }
}
