<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\ApplicationCommandOptionTypes;

class ApplicationCommandInteractionDataOptionStructure
{
    public string $name;
    public ApplicationCommandOptionTypes $type;
    public string|int|float|bool|null $value;
    /**
     * @var \Exan\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public bool $focused;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandOptionTypes::from($value);
    }
}
