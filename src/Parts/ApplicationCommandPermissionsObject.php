<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-permissions-object
 */
class ApplicationCommandPermissionsObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;

    /**
     * @var \Exan\Dhp\Parts\ApplicationCommandPermissions[]
     */
    public array $permissions;
}
