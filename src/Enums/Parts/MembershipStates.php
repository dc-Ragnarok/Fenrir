<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums\Parts;

enum MembershipStates: int
{
    case INVITED = 1;
    case ACCEPTED = 2;
}
