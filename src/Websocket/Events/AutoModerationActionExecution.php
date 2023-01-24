<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Enums\Parts\TriggerType;
use Exan\Dhp\Parts\AutoModeractionAction;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-action-execution
 */
class AutoModerationActionExecution
{
    public string $guild_id;
    public AutoModeractionAction $action;
    public string $rule_id;
    public TriggerType $rule_trigger_types;
    public string $user_id;
    public ?string $channel_id;
    public ?string $message_id;
    public ?string $alert_system_message_id;
    public ?string $content;
    public ?string $matched_keyword;
    public ?string $matched_content;
}
