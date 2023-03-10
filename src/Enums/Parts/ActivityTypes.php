<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums\Parts;

enum ActivityTypes: int
{
    case Game = 0;
    case Streaming = 1;
    case Listening = 2;
    case Watching = 3;
    case Custom = 4;
    case Competing = 5;
}
