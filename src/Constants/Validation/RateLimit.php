<?php

declare(strict_types=1);

namespace Exan\Fenrir\Constants\Validation;

use Exan\Fenrir\Constants\Validation\Traits\WithinLimit;

class RateLimit
{
    use WithinLimit;

    public const MIN = 0;
    public const MAX = 21600;
}
