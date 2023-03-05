<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Attributes\Partial;

class AuditLog
{
    /**
     * @var \Exan\Fenrir\Parts\ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var \Exan\Fenrir\Parts\AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var \Exan\Fenrir\Parts\AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var \Exan\Fenrir\Parts\GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var \Exan\Fenrir\Parts\Integration[]
     */
    #[Partial]
    public ?array $integrations;
    /**
     * @var \Exan\Fenrir\Parts\Channel[]
     */
    public ?array $threads;
    /**
     * @var \Exan\Fenrir\Parts\User[]
     */
    public ?array $users;
    /**
     * @var \Exan\Fenrir\Parts\Webhook[]
     */
    public ?array $webhooks;
}
