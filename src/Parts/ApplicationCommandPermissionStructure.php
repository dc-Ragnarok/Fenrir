<?php

namespace Exan\Dhp\Parts;

use \Exan\Dhp\Enums\Parts\ApplicationCommandPermissionTypes;

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
