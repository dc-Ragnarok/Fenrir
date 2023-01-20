<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Component;

enum SelectMenuType: int
{
    case String = 3;
    case User = 5;
    case Role = 6;
    case Mentionable = 7;
    case Channel = 8;
}
