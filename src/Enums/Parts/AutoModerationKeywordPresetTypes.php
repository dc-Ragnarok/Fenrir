<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums\Parts;

enum AutoModerationKeywordPresetTypes: int
{
    case PROFANITY = 1;
    case SEXUAL_CONTENT = 2;
    case SLURS = 3;
}
