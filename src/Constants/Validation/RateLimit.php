<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants\Validation;

use Ragnarok\Fenrir\Constants\Validation\Traits\WithinLimit;

class RateLimit
{
    use WithinLimit;

    public const MIN = 0;
    public const MAX = 21600;
}
