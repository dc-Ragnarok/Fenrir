<?php

namespace Exan\Dhp\Enums\Parts;

enum ActionType: int
{
    case BLOCK_MESSAGE = 1;
    case SENT_ALERT_MESSAGE = 2;
    case TIMEOUT = 3;
}
