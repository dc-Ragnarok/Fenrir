<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Enums\AutoModerationRuleTriggerType;
use Ragnarok\Fenrir\Parts\AutoModerationAction;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-action-execution
 */
class AutoModerationActionExecution
{
    public string $guild_id;
    public AutoModerationAction $action;
    public string $rule_id;
    public AutoModerationRuleTriggerType $rule_trigger_types;
    public string $user_id;
    public ?string $channel_id;
    public ?string $message_id;
    public ?string $alert_system_message_id;
    public ?string $content;
    public ?string $matched_keyword;
    public ?string $matched_content;

    public function setRuleTriggerTypes(int $value): void
    {
        $this->rule_trigger_types = AutoModerationRuleTriggerType::from($value);
    }
}
