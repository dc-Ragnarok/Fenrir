<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;

class AuditLog
{
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject[]
     */
    public ?array $application_commands;
    /**
     * @var \Ragnarok\Fenrir\Parts\AuditLogEntry[]
     */
    public ?array $audit_log_entries;
    /**
     * @var \Ragnarok\Fenrir\Parts\AutoModerationRule[]
     */
    public ?array $auto_moderation_rules;
    /**
     * @var \Ragnarok\Fenrir\Parts\GuildScheduledEvent[]
     */
    public ?array $guild_scheduled_events;
    /**
     * @var \Ragnarok\Fenrir\Parts\Integration[]
     */
    #[Partial]
    public ?array $integrations;
    /**
     * @var \Ragnarok\Fenrir\Parts\Channel[]
     */
    public ?array $threads;
    /**
     * @var \Ragnarok\Fenrir\Parts\User[]
     */
    public ?array $users;
    /**
     * @var \Ragnarok\Fenrir\Parts\Webhook[]
     */
    public ?array $webhooks;
}
