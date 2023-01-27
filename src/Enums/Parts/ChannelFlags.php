<?php

namespace Exan\Dhp\Enums\Parts;

enum ChannelFlags: int
{
    case PINNED = 1 << 1;
    case REQUIRE_TAG = 1 << 4;
}
