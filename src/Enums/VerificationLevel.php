<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum VerificationLevel: int
{
    case NONE = 0;
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;
    case VERY_HIGH = 4;
}
