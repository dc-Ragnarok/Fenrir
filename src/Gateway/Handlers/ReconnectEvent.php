<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Gateway\Handlers\Traits\ReconnectsToGateway;

class ReconnectEvent extends GatewayEvent
{
    use ReconnectsToGateway;

    public static function getEventName(): string
    {
        return '7';
    }

    public function execute(): void
    {
        $this->reconnect(
            $this->connection,
            $this->logger,
            $this->retrier,
        );
    }
}
