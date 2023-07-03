<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum MessageComponentType: int
{
    case ACTION_ROW = 1;
    case BUTTON = 2;
    case STRING_SELECT = 3;
    case TEXT_INPUT = 4;
    case USER_SELECT = 5;
    case ROLE_SELECT = 6;
    case MENTIONABLE_SELECT = 7;
    case CHANNEL_SELECT = 8;
}
