<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers\Meta;

use Exan\Retrier\Retrier;
use Ragnarok\Fenrir\Gateway\Events\Meta\UnacknowledgedHeartbeatEvent as BaseUnacknowledgedHeartbeatEvent;
use Ragnarok\Fenrir\Gateway\Handlers\Traits\ReconnectsToGateway;

class UnacknowledgedHeartbeatEvent extends BaseUnacknowledgedHeartbeatEvent
{
    use ReconnectsToGateway;

    public function execute(): void
    {
        $this->reconnect(
            $this->connection,
            $this->logger,
            new Retrier(),
        );
    }
}
