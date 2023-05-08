<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class RecoverableInvalidSessionEvent extends ReconnectEvent
{
    public static function getEventName(): string
    {
        return '9';
    }

    public function filter(): bool
    {
        return InvalidSessionEvent::isRecoverable($this->payload);
    }
}
