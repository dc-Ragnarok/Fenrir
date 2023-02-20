<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum TargetTypes: int
{
    case STREAM = 1;
    case EMBEDDED_APPLICATION = 2;
}
