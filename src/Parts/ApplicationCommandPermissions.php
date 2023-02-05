<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-permissions-object-application-command-permissions-structure
 */
class ApplicationCommandPermissions
{
    public string $id;
    public string $application_id;
    public bool $permission;
}
