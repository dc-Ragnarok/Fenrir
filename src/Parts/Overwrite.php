<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\OverwriteType;

class Overwrite
{
    public string $id;
    public OverwriteType $type;
    public string $allow;
    public string $deny;
}
