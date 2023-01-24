<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Carbon\Carbon;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-timestamps
 */
class ActivityTimestamps
{
    public Carbon $start;
    public Carbon $end;
}
