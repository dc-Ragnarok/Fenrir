<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class AuditLog
{
    /**
     * @var ApplicationCommandPermissionObject[]
     */
    #[ArrayMapping(ApplicationCommandPermissionObject::class)]
    public ?array $application_commands;
    /**
     * @var AuditLogEntry[]
     */
    #[ArrayMapping(AuditLogEntry::class)]
    public ?array $audit_log_entries;
    /**
     * @var AutoModerationRule[]
     */
    #[ArrayMapping(AutoModerationRule::class)]
    public ?array $auto_moderation_rules;
    /**
     * @var GuildScheduledEvent[]
     */
    #[ArrayMapping(GuildScheduledEvent::class)]
    public ?array $guild_scheduled_events;
    /**
     * @var Integration[]
     */
    #[ArrayMapping(Integration::class)]
    public ?array $integrations;
    /**
     * @var Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public ?array $threads;
    /**
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public ?array $users;
    /**
     * @var Webhook[]
     */
    #[ArrayMapping(Webhook::class)]
    public ?array $webhooks;
}
