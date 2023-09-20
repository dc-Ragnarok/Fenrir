<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Enums\ChannelType;

class ApplicationCommandOptionStructure
{
    public ApplicationCommandOptionType $type;
    public string $name;
    /**
     * @var array<string, string>
     */
    public ?array $name_localizations;
    public string $description;
    /**
     * @var array<string, string>
     */
    public ?array $description_localizations;
    public ?bool $required;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandOptionChoice[]
     */
    public ?array $choices;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure[]
     */
    public ?array $options;
    /**
     * @var \Ragnarok\Fenrir\Enums\ChannelType[]
     */
    public ?array $channel_types;
    public int|float|null $min_value;
    public int|float|null $max_value;
    public ?int $min_length;
    public ?int $max_length;
    public ?bool $autocomplete;

    public function setMinValue(mixed $value): void
    {
        $this->min_value = $value;
    }

    public function setMaxValue(mixed $value): void
    {
        $this->max_value = $value;
    }

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandOptionType::from($value);
    }

    public function setChannelType(array $value): void
    {
        $this->channel_types = [];

        foreach ($value as $entry) {
            $this->channel_types[] = ChannelType::from($entry);
        }
    }
}
