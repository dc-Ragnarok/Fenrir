<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\OverwriteTypes;

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
