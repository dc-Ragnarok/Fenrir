<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

abstract class IdentifyEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return '10';
    }

    public function execute(): void
    {
        $this->connection->sendHeartbeat();

        $this->connection->startAutomaticHeartbeats($this->payload->d->heartbeat_interval);
    }
}
