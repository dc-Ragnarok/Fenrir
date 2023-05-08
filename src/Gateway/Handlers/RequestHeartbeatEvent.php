<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class RequestHeartbeatEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return '1';
    }

    public function execute(): void
    {
        $this->connection->sendHeartbeat();
    }
}
