<?php

namespace Exan\Dhp\Enums\Parts;

enum GuildScheduledEventEntityTypes: int
{
    case STAGE_INSTANCE = 1;
    case VOICE = 2;
    case EXTERNAL = 3;
}
