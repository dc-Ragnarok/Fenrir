<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum NsfwLevels: int
{
    case DEFAULT = 0;
    case EXPLICIT = 1;
    case SAFE = 2;
    case AGE_RESTRICTED = 3;
}
