<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class ApplicationCommandInteractionDataOptionStructure
{
    public string $name;
    public ApplicationCommandOptionType $type;
    public string|int|float|bool|null $value;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandInteractionDataOptionStructure::class)]
    public ?array $options;
    public bool $focused;

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandOptionType::tryFrom($value);
    }
}
