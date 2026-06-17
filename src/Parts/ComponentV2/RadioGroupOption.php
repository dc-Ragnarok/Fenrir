<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

/**
 * @see https://docs.discord.com/developers/components/reference#radio-group-option
 */
class RadioGroupOption
{
    public string $value;
    public string $label;
    public ?string $description;
    public ?bool $default;
}
