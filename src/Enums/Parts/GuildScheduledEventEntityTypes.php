<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum GuildScheduledEventEntityTypes: int
{
    case STAGE_INSTANCE = 1;
    case VOICE = 2;
    case EXTERNAL = 3;
}
