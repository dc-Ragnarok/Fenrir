<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class ApplicationCommandPermissionObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandPermissionStructure[]
     */
    public array $permissions;
}
