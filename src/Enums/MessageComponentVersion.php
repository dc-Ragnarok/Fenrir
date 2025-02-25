<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum MessageComponentVersion: int
{
    case v1 = 1 << 1;
    case v2 = 1 << 2;
}
