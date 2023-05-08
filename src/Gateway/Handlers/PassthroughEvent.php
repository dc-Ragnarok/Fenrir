<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class PassthroughEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return '0';
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
