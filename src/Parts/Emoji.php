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
}
