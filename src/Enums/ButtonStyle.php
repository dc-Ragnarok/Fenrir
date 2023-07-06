<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ButtonStyle: int
{
    case Primary = 1;
    case Secondary = 2;
    case Success = 3;
    case Danger = 4;
    case Link = 5;
}
