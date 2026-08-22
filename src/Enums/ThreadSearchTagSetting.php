<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ThreadSearchTagSetting: string
{
    case MATCH_ALL = 'match_all';
    case MATCH_SOME = 'match_some';
}
