<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\ApplicationCommandPermissions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-rule-create
 */
class AutoModerationRuleCreate extends ApplicationCommandPermissions
{
}
