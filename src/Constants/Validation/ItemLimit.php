<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants\Validation;

use Ragnarok\Fenrir\Constants\Validation\Traits\WithinLimit;

class ItemLimit
{
    use WithinLimit;

    public const MIN = 1;
    public const MAX = 100;
}
