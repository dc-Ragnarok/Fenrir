<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

class ApplicationCommandInteractionDataOptionStructure
{
    public string $name;
    public int $type;
    public string|int|float|bool|null $value;
    /**
     * @var \Exan\Finrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public bool $focused;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
