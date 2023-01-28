<?php

namespace Exan\Dhp\Const\Validation;

use Exan\Dhp\Const\Validation\Traits\WithinLimit;

class ItemLimit
{
    use WithinLimit;

    public const MIN = 1;
    public const MAX = 100;
}
