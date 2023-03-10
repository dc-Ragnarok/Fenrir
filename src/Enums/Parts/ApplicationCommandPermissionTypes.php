<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Parts;

enum ApplicationCommandPermissionTypes: int
{
    case ROLE = 1;
    case USER = 2;
    case CHANNEL = 3;
}
