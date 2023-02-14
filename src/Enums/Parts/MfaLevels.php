<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Parts;

enum MfaLevels: int
{
    case NONE = 0;
    case ELEVATED = 1;
}
