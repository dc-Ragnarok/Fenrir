<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\ApplicationCommandPermissions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-rule-create
 */
class AutoModerationRuleCreate extends ApplicationCommandPermissions
{
}
