<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\OverwriteTypes;

class Overwrite
{
    public string $id;
    public OverwriteTypes $type;
    public string $allow;
    public string $deny;

    public function setType(int $value): void
    {
        $this->type = OverwriteTypes::from($value);
    }
}
