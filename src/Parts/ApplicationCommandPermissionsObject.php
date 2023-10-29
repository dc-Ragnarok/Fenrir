<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-permissions-object
 */
class ApplicationCommandPermissionsObject
{
    public string $id;
    public string $application_id;
    public string $guild_id;
    /** @var ApplicationCommandPermissions[] */
    #[ArrayMapping(ApplicationCommandPermissions::class)]
    public array $permissions;
}
