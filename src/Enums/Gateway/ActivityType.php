<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Gateway;

enum ActivityType: int
{
    case GAME = 0;
    case STREAMING = 1;
    case LISTENING = 2;
    case WATCHING = 3;
    case CUSTOM = 4;
    case COMPETING = 5;
}
