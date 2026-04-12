<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://docs.discord.com/developers/components/reference#checkbox-group-option-structure
 */
class CheckboxGroupOption
{
    public ?string $description;
    public ?bool $default;
}
