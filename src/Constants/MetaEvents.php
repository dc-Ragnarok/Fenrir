<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants;

class MetaEvents
{
    final public const UNACKNOWLEDGED_HEARTBEAT = 'UNACKNOWLEDGED_HEARTBEAT';
    final public const HEARTBEAT = 'HEARTBEAT';

    final public const CONNECT = 'CONNECT';
    final public const DISCONNECT = 'DISCONNECT';

    final public const FATAL = 'FATAL';

    final public const RESUME = 'RESUME';
}
