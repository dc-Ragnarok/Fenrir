<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class ApplicationCommandOptionChoice
{
    public string $name;
    /**
     * Array of string => string
     * @var string[]
     */
    public ?array $name_localizations;
    public string|int|float $value;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
