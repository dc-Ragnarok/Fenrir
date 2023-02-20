<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\ApplicationCommandOptionTypes;
use Exan\Finrir\Enums\Parts\ChannelTypes;

class ApplicationCommandOptionStructure
{
    public ApplicationCommandOptionTypes $type;
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
     * @var \Exan\Finrir\Parts\ApplicationCommandOptionChoice[]
     */
    public ?array $choices;
    /**
     * @var \Exan\Finrir\Parts\ApplicationCommandOptionStructure[]
     */
    public ?array $options;
    /**
     * @var \Exan\Finrir\Enums\Parts\ChannelTypes[]
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
        $this->type = ApplicationCommandOptionTypes::from($value);
    }

    public function setChannelTypes(array $value): void
    {
        $this->channel_types = [];

        foreach ($value as $entry) {
            $this->channel_types[] = ChannelTypes::from($entry);
        }
    }
}
