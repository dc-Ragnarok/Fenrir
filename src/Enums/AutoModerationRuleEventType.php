<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum AutoModerationRuleEventType: int
{
    case MESSAGE_SEND = 1;
}
