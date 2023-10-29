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
     * @var ApplicationCommandInteractionDataOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandInteractionDataOptionStructure::class)]
    public ?array $options;
    public bool $focused;
}
