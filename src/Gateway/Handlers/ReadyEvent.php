<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Constants\OpCodes;

class ReadyEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return OpCodes::EVENTS;
    }

    public function filter(): bool
    {
        return isset($this->payload->t) && $this->payload->t === Events::READY;
    }

    public function execute(): void
    {
        if (
            !isset(
                $this->payload->d,
                $this->payload->d->resume_gateway_url,
                $this->payload->d->session_id
            )
        ) {
            return;
        }

        $this->connection->setResumeUrl($this->payload->d->resume_gateway_url);
        $this->connection->setSessionId($this->payload->d->session_id);
    }
}
