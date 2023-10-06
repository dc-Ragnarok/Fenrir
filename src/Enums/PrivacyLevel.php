<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum PrivacyLevel: int
{
    case PUBLIC = 1;
    case GUILD_ONLY = 2;
}
