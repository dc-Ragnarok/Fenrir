<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Command;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Validation\Command;
use Ragnarok\Fenrir\Enums\ApplicationCommandTypes;
use Ragnarok\Fenrir\Enums\ApplicationIntegrationType;
use Ragnarok\Fenrir\Enums\InteractionContextType;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\Command\InvalidCommandNameException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;
use Spatie\Regex\Regex;

class CommandBuilder
{
    use GetNew;

    private array $data = [];

    /**
     * @var ApplicationIntegrationType[]
     */
    private array $integrationTypes;

    /**
     * @var InteractionContextType[]
     */
    private array $contextTypes;

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
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Permission> $permissions
     */
    public function setDefaultMemberPermissions(Bitwise $permissions): self
    {
        $this->data['default_member_permissions'] = $permissions->getBitSet();

        return $this;
    }

    /**
     * @return Bitwise<\Ragnarok\Fenrir\Enums\Permission>
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

    public function setIntegrationTypes(ApplicationIntegrationType ...$integrationTypes): self
    {
        $this->integrationTypes = $integrationTypes;

        return $this;
    }

    public function getIntegrationTypes(): ?array
    {
        return $this->integrationTypes ?? null;
    }

    public function setContexts(InteractionContextType ...$contextTypes): self
    {
        $this->contextTypes = $contextTypes;

        return $this;
    }

    public function getContexts(): ?array
    {
        return $this->contextTypes ?? null;
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
                static fn (CommandOptionBuilder $option) => $option->get(),
                $this->commandOptionBuilders
            );
        }

        if (isset($this->integrationTypes)) {
            $data['integration_types'] = array_map(
                fn (ApplicationIntegrationType $integrationType) => $integrationType->value,
                $this->integrationTypes
            );
        }

        if (isset($this->contextTypes)) {
            $data['contexts'] = array_map(
                fn (InteractionContextType $contextType) => $contextType->value,
                $this->contextTypes
            );
        }

        return $data;
    }
}
