<?php

namespace Exan\Dhp\Const\Validation;

use Exan\Dhp\Const\Validation\Traits\WithinLimit;

class RateLimit
{
    use WithinLimit;

    public const MIN = 0;
    public const MAX = 21600;
}
