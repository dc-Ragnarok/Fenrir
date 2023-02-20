<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Parts;

enum InviteTargetTypes: int
{
    case STREAM = 1;
    case EMBEDDED_APPLICATION = 2;
}
