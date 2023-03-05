<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Const\Validation;

use Ragnarok\Fenrir\Const\Validation\Traits\WithinLimit;

class RateLimit
{
    use WithinLimit;

    public const MIN = 0;
    public const MAX = 21600;
}
