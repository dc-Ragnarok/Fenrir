<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\ApplicationCommandPermissionTypes;

class ApplicationCommandPermissionStructure
{
    public string $id;
    public ApplicationCommandPermissionTypes $type;
    public bool $permission;

    public function setType(int $value): void
    {
        $this->type = ApplicationCommandPermissionTypes::from($value);
    }
}
