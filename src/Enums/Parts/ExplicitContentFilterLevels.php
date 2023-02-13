<?php

namespace Exan\Dhp\Enums\Parts;

enum ExplicitContentFilterLevels: int
{
    case DISABLED = 0;
    case MEMBERS_WITHOUT_ROLES = 1;
    case ALL_MEMBERS = 2;
}
