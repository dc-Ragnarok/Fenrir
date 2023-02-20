<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Attributes\Partial;

class AuditLog
{
    /**
     * @var \Exan\Finrir\Parts\ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var \Exan\Finrir\Parts\AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var \Exan\Finrir\Parts\AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var \Exan\Finrir\Parts\GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var \Exan\Finrir\Parts\Integration[]
     */
    #[Partial]
    public ?array $integrations;
    /**
     * @var \Exan\Finrir\Parts\Channel[]
     */
    public ?array $threads;
    /**
     * @var \Exan\Finrir\Parts\User[]
     */
    public ?array $users;
    /**
     * @var \Exan\Finrir\Parts\Webhook[]
     */
    public ?array $webhooks;
}
