<?php

namespace Exan\Dhp\Parts;


class ApplicationCommandOptionChoice
{
    public string $name;
    /**
     * @var array<string, string>
     */
    public ?array $name_localizations;
    public string|int|float $value;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
