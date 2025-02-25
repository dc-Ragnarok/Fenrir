<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum UnfurledMediaItemLoadingState: int
{
    case UNKNOWN = 0;
    case LOADING = 1;
    case LOADED_SUCCESS = 2;
    case LOADED_NOT_FOUND = 3;
}
