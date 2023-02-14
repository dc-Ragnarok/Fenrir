<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Parts;

enum SortOrderTypes: int
{
    case LATEST_ACTIVITY = 0;
    case CREATION_DATE = 1;
}
