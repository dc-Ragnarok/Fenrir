<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum AutoModerationRuleTriggerType: int
{
    case KEYWORD = 1;
    case SPAM = 3;
    case KEYWORD_PRESET = 4;
    case MENTION_SPAM = 5;
    case MEMBER_PROFILE = 6;
}
