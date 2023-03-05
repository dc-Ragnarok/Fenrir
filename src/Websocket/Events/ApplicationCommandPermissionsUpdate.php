<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\ApplicationCommandPermissions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#application-command-permissions-update
 */
class ApplicationCommandPermissionsUpdate extends ApplicationCommandPermissions
{
}
