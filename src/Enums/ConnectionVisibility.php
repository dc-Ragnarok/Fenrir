<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ConnectionVisibility: int
{
    case None = 0;
    case Everyone = 1;
}
