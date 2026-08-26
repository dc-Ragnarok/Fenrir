<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum MessageFlag: int
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
    case IS_VOICE_MESSAGE = 1 << 13;
    case HAS_SNAPSHOT = 1 << 14;
    /**
     * Opts a message into the components v2 layout. Required to use any
     * component above type 8, and mutually exclusive with content and embeds.
     */
    case IS_COMPONENTS_V2 = 1 << 15;
}
