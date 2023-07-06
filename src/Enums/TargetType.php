<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum TargetType: int
{
    case STREAM = 1;
    case EMBEDDED_APPLICATION = 2;
}
