<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class HeartbeatAcknowledgedEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return '11';
    }

    public function execute(): void
    {
        $this->connection->acknowledgeHeartbeat();
    }
}
