<?php

namespace Exan\Dhp\Enums\Parts;

enum ActivityType: int
{
    case Game = 0;
    case Streaming = 1;
    case Listening = 2;
    case Watching = 3;
    case Custom = 4;
    case Competing = 5;
}
