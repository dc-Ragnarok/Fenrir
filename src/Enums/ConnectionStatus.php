<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ConnectionStatus: string
{
    case ONLINE = 'online';
    case IDLE = 'idle';
    case DO_NOT_DISTURB = 'dnd';
}
