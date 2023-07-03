<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandTypes;

class ApplicationCommand
{
    public string $id;
    public ?ApplicationCommandTypes $type;
    public string $application_id;
    public ?string $guild_id;
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
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure[]
     */
    public ?array $options;
    public ?string $default_member_permissions;
    public ?bool $dm_permission;
    public ?bool $default_permission;
    public ?bool $nsfw;
    public string $version;

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandTypes::from($value);
    }
}
