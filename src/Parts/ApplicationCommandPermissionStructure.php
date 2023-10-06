<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationCommandPermissionType;

class ApplicationCommandPermissionStructure
{
    public string $id;
    public ApplicationCommandPermissionType $type;
    public bool $permission;

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandPermissionType::tryFrom($value);
    }
}
