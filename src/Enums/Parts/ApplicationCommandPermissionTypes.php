<?php

namespace Exan\Dhp\Enums\Parts;

enum ApplicationCommandPermissionTypes: int
{
    case ROLE = 1;
    case USER = 2;
    case CHANNEL = 3;
}
