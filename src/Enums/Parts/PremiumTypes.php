<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums\Parts;

enum PremiumTypes: int
{
    case NONE = 0;
    case NITRO_CLASSIC = 1;
    case NITRO = 2;
    case NITRO_BASIC = 3;
}
