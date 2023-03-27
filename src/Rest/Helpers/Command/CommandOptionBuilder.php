<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Command;

use Ragnarok\Fenrir\Enums\Parts\ApplicationCommandOptionTypes;
use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class CommandOptionBuilder
{
    use GetNew;

    private array $data = [];

    /** @var CommandOptionBuilder[] */
    private array $options;

    /** @var ChannelTypes[] */
    private array $channelTypes;

    public function setType(ApplicationCommandOptionTypes $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function getType(): ?ApplicationCommandOptionTypes
    {
        return isset($this->data['type'])
            ? ApplicationCommandOptionTypes::from($this->data['type'])
            : null;
    }

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @param array<string, string> $localizedNames `key => locale`, `value => name`
     */
    public function setNameLocalizations(array $localizedNames): self
    {
        $this->data['name_localizations'] = $localizedNames;

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @return array<string, string> `key => locale`, `value => name`
     */
    public function getNameLocalizations(): ?array
    {
        return $this->data['name_localizations'] ?? null;
    }

    public function setDescription(string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @param array<string, string> $localizedNames `key => locale`, `value => description`
     */
    public function setDescriptionLocalizations(array $localizedDescriptions): self
    {
        $this->data['description_localizations'] = $localizedDescriptions;

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @return array<string, string> `key => locale`, `value => description`
     */
    public function getDescriptionLocalizations(): ?array
    {
        return $this->data['description_localizations'] ?? null;
    }

    public function setRequired(bool $required): self
    {
        $this->data['required'] = $required;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->data['required'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @param array<string, string> $localizedNames `key => locale`, `value => description`
     */
    public function addChoice(string $name, string|int|float $value, array $localizedNames = [])
    {
        if (!isset($this->data['choices'])) {
            $this->data['choices'] = [];
        }

        $this->data['choices'][] = [
            'name' => $name,
            'localized_names' => $localizedNames,
            'value' => $value,
        ];
    }

    public function getChoices()
    {
        return $this->data['choices'] ?? null;
    }

    public function addOption(CommandOptionBuilder $commandOptionBuilder)
    {
        if (!isset($this->options)) {
            $this->options = [];
        }

        $this->options[] = $commandOptionBuilder;

        return $this;
    }

    /** @return ?CommandOptionBuilder[] */
    public function getOptions(): ?array
    {
        return $this->options ?? null;
    }

    public function setChannelTypes(ChannelTypes ...$channelTypes): self
    {
        $this->channelTypes = $channelTypes;

        return $this;
    }

    /** @return ?ChannelTypes[] */
    public function getChannelTypes(): ?array
    {
        return $this->channelTypes ?? null;
    }

    public function setMinValue(float|int $minValue): self
    {
        $this->data['min_value'] = $minValue;

        return $this;
    }

    public function getMinValue(): null|float|int
    {
        return $this->data['min_value'] ?? null;
    }

    public function setMaxValue(float|int $minValue): self
    {
        $this->data['max_value'] = $minValue;

        return $this;
    }

    public function getMaxValue(): null|float|int
    {
        return $this->data['max_value'] ?? null;
    }

    public function setMinLength(int $minLength): self
    {
        $this->data['min_length'] = $minLength;

        return $this;
    }

    public function getMinLength(): ?int
    {
        return $this->data['min_length'] ?? null;
    }

    public function setMaxLength(int $minLength): self
    {
        $this->data['max_length'] = $minLength;

        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->data['max_length'] ?? null;
    }

    public function setAutoComplete(bool $autoComplete): self
    {
        $this->data['autocomplete'] = $autoComplete;

        return $this;
    }

    public function getAutoComplete(): ?bool
    {
        return $this->data['autocomplete'] ?? null;
    }

    public function get(): array
    {
        $data = $this->data;

        if (isset($this->options)) {
            $data['options'] = array_map(
                fn (CommandOptionBuilder $option) => $option->get(),
                $this->options
            );
        }

        if (isset($this->channelTypes)) {
            $data['channel_types'] = array_map(
                fn (ChannelTypes $type) => $type->value,
                $this->channelTypes
            );
        }

        return $data;
    }
}
