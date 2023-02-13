<?php

namespace Exan\Dhp\Parts;

class AuditLog
{
    /**
     * @var ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var Integration[]
     */
    public ?array $integrations;
    /**
     * @var Channel[]
     */
    public ?array $threads;
    /**
     * @var User[]
     */
    public ?array $users;
    /**
     * @var Webhook[]
     */
    public ?array $webhooks;
}
