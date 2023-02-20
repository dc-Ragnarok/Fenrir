<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class ApplicationCommandPermissionObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /**
     * @var \Exan\Fenrir\Parts\ApplicationCommandPermissionStructure[]
     */
    public array $permissions;
}
