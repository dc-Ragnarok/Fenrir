<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\GatewayCloseCodes;
use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

class InvalidSessionEvent extends GatewayEvent
{
    public static function getEventName(): string
    {
        return OpCodes::INVALID_SESSION;
    }

    public static function isRecoverable(Payload $payload): bool
    {
        return isset($payload->d) && $payload->d === true;
    }

    public function filter(): bool
    {
        return !self::isRecoverable($this->payload);
    }

    public function execute(): void
    {
        $this->connection->disconnect(
            GatewayCloseCodes::LIB_INSTANTIATED_RECONNECT,
            'Invalid session, attempting to establish new connection'
        );
    }
}
