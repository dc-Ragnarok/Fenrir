<?php

declare(strict_types=1);

namespace Exan\Fenrir\Constants\Validation;

use Exan\Fenrir\Constants\Validation\Traits\WithinLimit;

class ItemLimit
{
    use WithinLimit;

    public const MIN = 1;
    public const MAX = 100;
}
