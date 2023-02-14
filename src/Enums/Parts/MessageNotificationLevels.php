<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Parts;

enum MessageNotificationLevels: int
{
    case ALL_MESSAGES = 0;
    case ONLY_MENTIONS = 1;
}
