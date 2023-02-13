<?php

namespace Exan\Dhp\Parts;

class AuditLog
{
    /**
     * @var \Exan\Dhp\Enums\Parts\ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var \Exan\Dhp\Enums\Parts\AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var \Exan\Dhp\Enums\Parts\AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var \Exan\Dhp\Enums\Parts\GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var \Exan\Dhp\Enums\Parts\Integration[]
     */
    public ?array $integrations;
    /**
     * @var \Exan\Dhp\Enums\Parts\Channel[]
     */
    public ?array $threads;
    /**
     * @var \Exan\Dhp\Enums\Parts\User[]
     */
    public ?array $users;
    /**
     * @var \Exan\Dhp\Enums\Parts\Webhook[]
     */
    public ?array $webhooks;
}
