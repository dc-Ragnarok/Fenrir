<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum ActionTypes: int
{
    case BLOCK_MESSAGE = 1;
    case SENT_ALERT_MESSAGE = 2;
    case TIMEOUT = 3;
}
