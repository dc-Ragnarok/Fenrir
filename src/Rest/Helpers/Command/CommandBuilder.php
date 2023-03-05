<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Command;

use Exan\Fenrir\Const\Validation\Command;
use Exan\Fenrir\Enums\Parts\ApplicationCommandTypes;
use Exan\Fenrir\Exceptions\Rest\Helpers\Command\InvalidCommandNameException;
use Exan\Fenrir\Rest\Helpers\GetNew;
use Spatie\Regex\Regex;

class CommandBuilder
{
    use GetNew;

    private array $data = [];

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

    /**
     * @see https://discord.com/developers/docs/reference#locales
     *
     * @param array<string, string> $localizedNames `key => locale`, `value => name`
     *
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


    public function setDescription(string $description): self
    {
        $this->data['description'] = $description;

        return $this;
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
     * @todo add options builder & implement
     */
    public function setOptions()
    {
    }

    /**
     * @todo implement
     */
    public function setDefaultMemberPermissions()
    {
    }

    public function setDmPermission(bool $allow): self
    {
        $this->data['dm_permissions'] = $allow;

        return $this;
    }

    public function setType(ApplicationCommandTypes $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function setNsfw(bool $nsfw): self
    {
        $this->data['nsfw'] = $nsfw;

        return $this;
    }

    public function isAllowedName($name): bool
    {
        return Regex::match(Command::NAME_REGEX, $name)->hasMatch();
    }

    public function get(): array
    {
        return $this->data;
    }
}
