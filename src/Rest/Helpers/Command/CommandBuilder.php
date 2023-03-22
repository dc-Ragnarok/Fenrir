<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Command;

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Constants\Validation\Command;
use Exan\Fenrir\Enums\Parts\ApplicationCommandTypes;
use Exan\Fenrir\Exceptions\Rest\Helpers\Command\InvalidCommandNameException;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\Helpers\GetNew;
use Spatie\Regex\Regex;

class CommandBuilder
{
    use GetNew;

    private array $data = [];

    /** @var ?CommandOptionBuilder[] */
    private array $commandOptionBuilders;

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-naming
     *
     * @throws InvalidCommandNameException
     */
    public function setName(string $name): self
    {
        if (!$this->isAllowedName($name)) {
            throw new InvalidCommandNameException($name);
        }

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
        foreach ($localizedNames as $name) {
            if (!$this->isAllowedName($name)) {
                throw new InvalidCommandNameException($name);
            }
        }

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
     * @return array<string, string> `key => locale`, `value => description`
     */
    public function getDescriptionLocalizations(): ?array
    {
        return $this->data['description_localizations'] ?? null;
    }

    public function addOption(CommandOptionBuilder $commandOptionBuilder): self
    {
        if (!isset($this->commandOptionBuilders)) {
            $this->commandOptionBuilders = [];
        }

        $this->commandOptionBuilders[] = $commandOptionBuilder;

        return $this;
    }

    /** @return ?CommandOptionBuilder[] */
    public function getOptions(): ?array
    {
        return $this->commandOptionBuilders ?? null;
    }

    /**
     * @param Bitwise<\Exan\Fenrir\Enums\Permissions> $permissions
     */
    public function setDefaultMemberPermissions(Bitwise $permissions): self
    {
        $this->data['default_member_permissions'] = $permissions->getBitSet();

        return $this;
    }

    /**
     * @return Bitwise<\Exan\Fenrir\Enums\Permissions>
     */
    public function getDefaultMemberPermissions(): ?Bitwise
    {
        return isset($this->data['default_member_permissions'])
            ? Bitwise::fromBitSet($this->data['default_member_permissions'])
            : null;
    }

    public function setDmPermission(bool $allow): self
    {
        $this->data['dm_permissions'] = $allow;

        return $this;
    }

    public function getDmPermission(): ?bool
    {
        return $this->data['dm_permissions'] ?? null;
    }

    public function setType(ApplicationCommandTypes $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function getType(): ?ApplicationCommandTypes
    {
        return isset($this->data['type'])
            ? ApplicationCommandTypes::from($this->data['type'])
            : null;
    }

    public function setNsfw(bool $nsfw): self
    {
        $this->data['nsfw'] = $nsfw;

        return $this;
    }

    public function getNsfw(): ?bool
    {
        return $this->data['nsfw'] ?? null;
    }

    private function isAllowedName($name): bool
    {
        return Regex::match(Command::NAME_REGEX, $name)->hasMatch();
    }

    public function get(): array
    {
        $data = $this->data;

        if (isset($this->commandOptionBuilders)) {
            $data['options'] = array_map(
                fn (CommandOptionBuilder $option) => $option->get(),
                $this->commandOptionBuilders
            );
        }

        return $data;
    }

    public function matchesApplicationCommand(ApplicationCommand $applicationCommand): bool
    {
        $applicationCommandBuilder = self::fromApplicationCommand($applicationCommand)->get();

        foreach ($this->get() as $key => $value) {
            if ($applicationCommandBuilder[$key] !== $value) {
                return false;
            }
        }

        return true;
    }

    protected static function fromApplicationCommand(ApplicationCommand $applicationCommand): self
    {
        $commandBuilder = new self();

        $commandBuilder->setDefaultMemberPermissions(
            Bitwise::from((int)$applicationCommand->default_member_permissions)
        );
        $commandBuilder->setDescription($applicationCommand->description);
        $commandBuilder->setDmPermission($applicationCommand->dm_permission);
        $commandBuilder->setName($applicationCommand->name);
        $commandBuilder->setNameLocalizations($applicationCommand->name_localizations ?? []);
        $commandBuilder->setNsfw($applicationCommand->nsfw);
        $commandBuilder->setType($applicationCommand->type);

        foreach ($applicationCommand->options ?? [] as $option) {
            $builder = CommandOptionBuilder::new();

            foreach ($option->choices as $choice) {
                $builder->addChoice($choice->name, $choice->value, $choice->name_localizations ?? []);
            }

            $builder
                ->setAutoComplete($option->autocomplete)
                ->setChannelTypes(...$option->channel_types ?? [])
                ->setDescription($option->description)
                ->setDescriptionLocalizations($option->description_localizations ?? [])
                ->setMaxLength($option->max_length)
                ->setMaxValue($option->max_value)
                ->setMinLength($option->min_length)
                ->setMinValue($option->min_value)
                ->setName($option->name)
                ->setNameLocalizations($option->name_localizations ?? [])
                ->setRequired($option->required)
                ->setType($option->type)
            ;

            $commandBuilder->addOption($builder);
        }

        return $commandBuilder;
    }
}
