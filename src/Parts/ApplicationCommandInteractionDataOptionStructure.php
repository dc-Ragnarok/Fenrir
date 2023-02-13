<?php

namespace Exan\Dhp\Parts;

class ApplicationCommandInteractionDataOptionStructure
{
    public string $name;
    public int $type;
    public string|int|float|bool|null $value;
    /**
     * @var \Exan\Dhp\Enums\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public bool $focused;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
