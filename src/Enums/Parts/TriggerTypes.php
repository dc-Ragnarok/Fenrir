<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum TriggerTypes: int
{
    case KEYWORD = 1;
    case SPAM = 3;
    case KEYWORD_PRESET = 4;
    case MENTION_SPAM = 5;
}
