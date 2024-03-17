<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class Role
{
    public string $id;
    public string $name;
    public int $color;
    public bool $hoist;
    public ?string $icon;
    public ?string $unicode_emoji;
    public int $position;
    public string $permissions;
    public bool $managed;
    public bool $mentionable;
    public ?RoleTags $tags;
    public int $flags;
}
