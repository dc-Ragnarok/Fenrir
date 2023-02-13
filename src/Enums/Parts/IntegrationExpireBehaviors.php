<?php

namespace Exan\Dhp\Enums\Parts;

enum IntegrationExpireBehaviors: int
{
    case REMOVE_ROLE = 0;
    case KICK = 1;
}
