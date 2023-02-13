<?php

namespace Exan\Dhp\Parts;

class ApplicationCommandPermissionObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /**
     * @var \Exan\Dhp\Enums\Parts\ApplicationCommandPermissionStructure[]
     */
    public array $permissions;
}
