<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands#application-command-permissions-object
 */
class AuditLog
{
    public array $application_commands;
    public array $audit_log_entries;
    public array $auto_moderation_rules;
    public array $guild_scheduled_events;
    public array $integrations;

    /**
     * @var \Exan\Dhp\Parts\Channel
     */
    public array $threads;

    /**
     * @var \Exan\Dhp\Parts\User[]
     */
    public array $users;

    public array $webhooks;

}
