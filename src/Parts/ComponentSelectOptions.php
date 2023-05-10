<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class ComponentSelectOptions
{
    public string $label;
    public string $value;
    public ?string $description;
    public ?Emoji $emoji;
    public ?bool $default;
}
