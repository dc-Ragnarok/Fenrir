<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum ConnectionStatus: string
{
    case ONLINE = 'online';
    case IDLE = 'idle';
    case DO_NOT_DISTURB = 'dnd';
}
