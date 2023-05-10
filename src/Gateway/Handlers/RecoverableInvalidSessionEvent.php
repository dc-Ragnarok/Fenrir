<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\OpCodes;

class RecoverableInvalidSessionEvent extends ReconnectEvent
{
    public static function getEventName(): string
    {
        return OpCodes::INVALID_SESSION;
    }

    public function filter(): bool
    {
        return InvalidSessionEvent::isRecoverable($this->payload);
    }
}
