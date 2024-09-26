<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum MessageReferenceType: int
{
    case DEFAULT = 0;
    case FORWARD = 1;
}
