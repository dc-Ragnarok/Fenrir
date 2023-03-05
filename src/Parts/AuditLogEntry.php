<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\AuditLogEvents;

class AuditLogEntry
{
    public ?string $target_id;
    /**
     * @var \Exan\Fenrir\Parts\AuditLogChange[]
     */
    public ?array $changes;
    public ?string $user_id;
    public string $id;
    public AuditLogEvents $action_type;
    public ?AuditEntryInfo $options;
    public ?string $reason;

    public function setActionType(int $value): void
    {
        $this->action_type = AuditLogEvents::from($value);
    }
}
