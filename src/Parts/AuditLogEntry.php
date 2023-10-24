<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\AuditLogEvents;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class AuditLogEntry
{
    public ?string $target_id;
    /**
     * @var \Ragnarok\Fenrir\Parts\AuditLogChange[]
     */
    #[ArrayMapping(AuditLogChange::class)]
    public ?array $changes;
    public ?string $user_id;
    public string $id;
    public AuditLogEvents $action_type;
    public ?OptionalAuditEntryInfo $options;
    public ?string $reason;
}
