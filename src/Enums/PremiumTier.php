<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum PremiumTier: int
{
    case NONE = 0;
    case TIER_1 = 1;
    case TIER_2 = 2;
    case TIER_3 = 3;
}
