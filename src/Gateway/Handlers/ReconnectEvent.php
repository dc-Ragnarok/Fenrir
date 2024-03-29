<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\Gateway\Handlers\Traits\ReconnectsToGateway;

class ReconnectEvent extends GatewayEvent
{
    use ReconnectsToGateway;

    public static function getEventName(): string
    {
        return OpCodes::RECONNECT;
    }

    public function execute(): void
    {
        $this->reconnect(
            $this->connection,
            $this->logger,
            $this->retrier,
        )->done(function () {
            $this->logger->info('Finished reconnecting');
        });
    }
}
