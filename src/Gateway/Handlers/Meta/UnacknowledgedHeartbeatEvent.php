<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers\Meta;

use Ragnarok\Fenrir\Constants\GatewayCloseCodes;
use Ragnarok\Fenrir\Gateway\Events\Meta\UnacknowledgedHeartbeatEvent as BaseUnacknowledgedHeartbeatEvent;

class UnacknowledgedHeartbeatEvent extends BaseUnacknowledgedHeartbeatEvent
{
    public function execute(): void
    {
        $this->connection->disconnect(
            GatewayCloseCodes::LIB_INSTANTIATED_RECONNECT,
            'Unacknowledged heartbeat, attempting reconnect'
        );
    }
}
