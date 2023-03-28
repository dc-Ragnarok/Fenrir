<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums\Parts;

enum ApplicationCommandTypes: int
{
    case CHAT_INPUT = 1;
    case USER = 2;
    case MESSAGE = 3;
}
