<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\OpCodes;

class PassthroughEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return OpCodes::EVENTS;
    }

    public function execute(): void
    {
        $currentSequence = $this->connection->getSequence();
        if (isset($this->payload->s) && (is_null($currentSequence) || $this->payload->s > $currentSequence)) {
            $this->connection->setSequence($this->payload->s);
        }

        $this->connection->getEventHandler()->handle($this->payload);
    }
}
