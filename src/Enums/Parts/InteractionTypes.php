<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Parts;

enum InteractionTypes: int
{
    case PING = 1;
    case APPLICATION_COMMAND = 2;
    case MESSAGE_COMPONENT = 3;
    case APPLICATION_COMMAND_AUTOCOMPLETE = 4;
    case MODAL_SUBMIT = 5;
}
