<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class AuditLog
{
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject[]
     */
    #[ArrayMapping(ApplicationCommandPermissionObject::class)]
    public ?array $application_commands;
    /**
     * @var \Ragnarok\Fenrir\Parts\AuditLogEntry[]
     */
    #[ArrayMapping(AuditLogEntry::class)]
    public ?array $audit_log_entries;
    /**
     * @var \Ragnarok\Fenrir\Parts\AutoModerationRule[]
     */
    #[ArrayMapping(AutoModerationRule::class)]
    public ?array $auto_moderation_rules;
    /**
     * @var \Ragnarok\Fenrir\Parts\GuildScheduledEvent[]
     */
    #[ArrayMapping(GuildScheduledEvent::class)]
    public ?array $guild_scheduled_events;
    /**
     * @var \Ragnarok\Fenrir\Parts\Integration[]
     */
    #[ArrayMapping(Integration::class)]
    public ?array $integrations;
    /**
     * @var \Ragnarok\Fenrir\Parts\Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public ?array $threads;
    /**
     * @var \Ragnarok\Fenrir\Parts\User[]
     */
    #[ArrayMapping(User::class)]
    public ?array $users;
    /**
     * @var \Ragnarok\Fenrir\Parts\Webhook[]
     */
    #[ArrayMapping(Webhook::class)]
    public ?array $webhooks;
}
