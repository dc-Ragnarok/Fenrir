<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Flags;

enum SystemChannelFlags: int
{
    case SUPPRESS_JOIN_NOTIFICATIONS = 1 << 0;
    case SUPPRESS_PREMIUM_SUBSCRIPTIONS = 1 << 1;
    case SUPPRESS_GUILD_REMINDER_NOTIFICATIONS = 1 << 2;
    case SUPPRESS_JOIN_NOTIFICATION_REPLIES = 1 << 3;
    case SUPPRESS_ROLE_SUBSCRIPTION_PURCHASE_NOTIFICATIONS = 1 << 4;
    case SUPPRESS_ROLE_SUBSCRIPTION_PURCHASE_NOTIFICATION_REPLIES = 1 << 5;
}
