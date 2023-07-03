<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events\Meta;

use Ragnarok\Fenrir\Constants\MetaEvents;

abstract class UnacknowledgedHeartbeatEvent extends MetaEvent
{
    public static function getEventName(): string
    {
        return MetaEvents::UNACKNOWLEDGED_HEARTBEAT;
    }
}
