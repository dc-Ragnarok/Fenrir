<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#auto-moderation-action-execution
 */
class AutoModerationActionExecution
{
    public string $guild_id;
    public object $action; // @TODO
    public string $rule_id;
    public int $rule_trigger_types; // @TODO
    public string $user_id;
    public ?string $channel_id;
    public ?string $message_id;
    public ?string $alert_system_message_id;
    public ?string $content;
    public ?string $matched_keyword;
    public ?string $matched_content;
}
