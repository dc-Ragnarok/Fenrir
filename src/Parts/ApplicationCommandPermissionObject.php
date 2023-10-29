<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class ApplicationCommandPermissionObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /**
     * @var ApplicationCommandPermissionStructure[]
     */
    #[ArrayMapping(ApplicationCommandPermissionStructure::class)]
    public array $permissions;
}
