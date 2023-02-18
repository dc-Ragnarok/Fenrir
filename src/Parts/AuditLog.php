<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Attributes\Partial;

class AuditLog
{
    /**
     * @var \Exan\Dhp\Parts\ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var \Exan\Dhp\Parts\AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var \Exan\Dhp\Parts\AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var \Exan\Dhp\Parts\GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var \Exan\Dhp\Parts\Integration[]
     */
    #[Partial]
    public ?array $integrations;
    /**
     * @var \Exan\Dhp\Parts\Channel[]
     */
    public ?array $threads;
    /**
     * @var \Exan\Dhp\Parts\User[]
     */
    public ?array $users;
    /**
     * @var \Exan\Dhp\Parts\Webhook[]
     */
    public ?array $webhooks;
}
