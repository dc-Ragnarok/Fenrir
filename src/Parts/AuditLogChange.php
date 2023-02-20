<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class AuditLogChange
{
    public mixed $new_value;
    public mixed $old_value;
    public string $key;
}
