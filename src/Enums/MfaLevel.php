<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum MfaLevel: int
{
    case NONE = 0;
    case ELEVATED = 1;
}
