<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\ApplicationCommandPermissions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-rule-create
 */
class AutoModerationRuleCreate extends ApplicationCommandPermissions
{
}
