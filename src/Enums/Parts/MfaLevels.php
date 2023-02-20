<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Parts;

enum MfaLevels: int
{
    case NONE = 0;
    case ELEVATED = 1;
}
