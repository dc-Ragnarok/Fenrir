<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Parts;

enum PremiumTiers: int
{
    case NONE = 0;
    case TIER_1 = 1;
    case TIER_2 = 2;
    case TIER_3 = 3;
}
