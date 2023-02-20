<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

class ApplicationCommandPermissionObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /**
     * @var \Exan\Finrir\Parts\ApplicationCommandPermissionStructure[]
     */
    public array $permissions;
}
