<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events\Meta;

use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Constants\MetaEvents;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;

abstract class UnacknowledgedHeartbeatEvent extends MetaEvent
{
    public static function getEventName(): string
    {
        return MetaEvents::UNACKNOWLEDGED_HEARTBEAT;
    }
}
