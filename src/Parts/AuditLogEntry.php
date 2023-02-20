<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\AuditLogEvents;

class AuditLogEntry
{
    public ?string $target_id;
    /**
     * @var \Exan\Finrir\Parts\AuditLogChange[]
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
