<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/emoji#emoji-object
 */
class Emoji
{
    public string $id;
    public ?string $name = null;
    public ?array $roles = null;
    public ?User $user = null;
    public ?bool $require_colons = null;
    public ?bool $managed = null;
    public bool $animated = false;
    public ?bool $available = null;

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
        return is_null($this->name)
            ? urlencode($this->id)
            : $this->name . ':' . $this->id;
    }

    public static function get(string $id, ?string $name = null, bool $animated = false): self
    {
        $emoji = new self();
        $emoji->id = $id;
        $emoji->name = $name;
        $emoji->animated = $animated;

        return $emoji;
    }
}
