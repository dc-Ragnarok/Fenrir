<?php

namespace Exan\Dhp\Enums\Parts;

enum ApplicationCommandPermissionType: int
{
    case ROLE = 1;
    case USER = 2;
    case CHANNEL = 3;
}
