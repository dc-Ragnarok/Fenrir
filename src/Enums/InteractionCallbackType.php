<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum InteractionCallbackType: int
{
    case PONG = 1;
    case CHANNEL_MESSAGE_WITH_SOURCE = 4;
    case DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE = 5;
    case DEFERRED_UPDATE_MESSAGE = 6;
    case UPDATE_MESSAGE = 7;
    case APPLICATION_COMMAND_AUTOCOMPLETE_RESULT = 8;
    case MODAL = 9;
    case LAUNCH_ACTIVITY = 12;
}
