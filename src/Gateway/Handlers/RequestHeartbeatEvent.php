<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\OpCodes;

class RequestHeartbeatEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return OpCodes::HEARTBEAT;
    }

    public function execute(): void
    {
        $this->connection->sendHeartbeat();
    }
}
