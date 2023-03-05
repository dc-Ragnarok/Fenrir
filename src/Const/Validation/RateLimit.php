<?php

declare(strict_types=1);

namespace Exan\Fenrir\Const\Validation;

use Exan\Fenrir\Const\Validation\Traits\WithinLimit;

class RateLimit
{
    use WithinLimit;

    public const MIN = 0;
    public const MAX = 21600;
}
