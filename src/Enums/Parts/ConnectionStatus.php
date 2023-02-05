<?php

namespace Exan\Dhp\Enums\Parts;

enum ConnectionStatus: string
{
    case ONLINE = 'online';
    case IDLE = 'idle';
    case DO_NOT_DISTURB = 'dnd';
}
