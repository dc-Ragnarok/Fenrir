<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Flags;

enum MessageFlags: int
{
    case CROSSPOSTED = 1 << 0;
    case IS_CROSSPOST = 1 << 1;
    case SUPPRESS_EMBEDS = 1 << 2;
    case SOURCE_MESSAGE_DELETED = 1 << 3;
    case URGENT = 1 << 4;
    case HAS_THREAD = 1 << 5;
    case EPHEMERAL = 1 << 6;
    case LOADING = 1 << 7;
    case FAILED_TO_MENTION_SOME_ROLES_IN_THREAD = 1 << 8;
    case SUPPRESS_NOTIFICATIONS = 1 << 12;
}
