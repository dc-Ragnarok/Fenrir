<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandTypes;
use Ragnarok\Fenrir\Enums\ApplicationIntegrationType;
use Ragnarok\Fenrir\Enums\InteractionContextType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

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
     * @var ApplicationCommandOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandOptionStructure::class)]
    public ?array $options;
    public ?string $default_member_permissions;
    /**
     * @deprecated use $this->contexts instead
     */
    public ?bool $dm_permission;
    public ?bool $default_permission;
    public ?bool $nsfw;
    public string $version;
    /**
     * @var ApplicationIntegrationType[]
     */
    #[ArrayMapping(ApplicationIntegrationType::class)]
    public ?array $integration_types;
    /**
     * @var InteractionContextType[]
     */
    #[ArrayMapping(InteractionContextType::class)]
    public ?array $contexts;
}
