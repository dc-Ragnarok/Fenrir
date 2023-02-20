<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum GuildScheduledEventStatus: int
{
    case SCHEDULED = 1;
    case ACTIVE = 2;
    case COMPLETED = 3;
    case CANCELED = 4;
}
