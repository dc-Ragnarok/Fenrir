<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Flags;

enum UserFlags: int
{
    case STAFF = 1 << 0;
    case PARTNER = 1 << 1;
    case HYPESQUAD = 1 << 2;
    case BUG_HUNTER_LEVEL_1 = 1 << 3;
    case HYPESQUAD_ONLINE_HOUSE_1 = 1 << 6;
    case HYPESQUAD_ONLINE_HOUSE_2 = 1 << 7;
    case HYPESQUAD_ONLINE_HOUSE_3 = 1 << 8;
    case PREMIUM_EARLY_SUPPORTER = 1 << 9;
    case TEAM_PSEUDO_USER = 1 << 10;
    case BUG_HUNTER_LEVEL_2 = 1 << 14;
    case VERIFIED_BOT = 1 << 16;
    case VERIFIED_DEVELOPER = 1 << 17;
    case CERTIFIED_MODERATOR = 1 << 18;
    case BOT_HTTP_INTERACTIONS = 1 << 19;
    case ACTIVE_DEVELOPER = 1 << 22;
}
