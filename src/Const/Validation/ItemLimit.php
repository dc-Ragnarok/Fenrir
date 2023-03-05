<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Const\Validation;

use Ragnarok\Fenrir\Const\Validation\Traits\WithinLimit;

class ItemLimit
{
    use WithinLimit;

    public const MIN = 1;
    public const MAX = 100;
}
