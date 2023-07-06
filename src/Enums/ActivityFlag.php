<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ActivityFlag: int
{
    case INSTANCE = 1 << 0;
    case JOIN = 1 << 1;
    case SPECTATE = 1 << 2;
    case JOIN_REQUEST = 1 << 3;
    case SYNC = 1 << 4;
    case PLAY = 1 << 5;
    case PARTY_PRIVACY_FRIENDS = 1 << 6;
    case PARTY_PRIVACY_VOICE_CHANNEL = 1 << 7;
    case EMBEDDED = 1 << 8;
}
