<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\ApplicationCommandPermissions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#application-command-permissions-update
 */
#[RequiresIntent(Intent::AUTO_MODERATION_CONFIGURATION)]
class ApplicationCommandPermissionsUpdate extends ApplicationCommandPermissions
{
}
