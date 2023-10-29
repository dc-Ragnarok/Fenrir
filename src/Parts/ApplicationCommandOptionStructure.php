<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class ApplicationCommandOptionStructure
{
    public ApplicationCommandOptionType $type;
    public string $name;
    /**
     * Array of string => string
     * @var string[]
     */
    public ?array $name_localizations;
    public string $description;
    /**
     * Array of string => string
     * @var string[]
     */
    public ?array $description_localizations;
    public ?bool $required;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandOptionChoice[]
     */
    #[ArrayMapping(ApplicationCommandOptionChoice::class)]
    public ?array $choices;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandOptionStructure::class)]
    public ?array $options;
    /**
     * @var \Ragnarok\Fenrir\Enums\ChannelType[]
     */
    #[ArrayMapping(ChannelType::class)]
    public ?array $channel_types;
    public int|float|null $min_value;
    public int|float|null $max_value;
    public ?int $min_length;
    public ?int $max_length;
    public ?bool $autocomplete;
}
