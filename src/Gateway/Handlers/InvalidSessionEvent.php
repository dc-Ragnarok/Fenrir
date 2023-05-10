<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\Gateway\Objects\Payload;
use React\Promise\ExtendedPromiseInterface;
use Throwable;

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
        $this->connection->stopAutomaticHeartbeats();

        $reason = 'Invalid session, attempting to establish new connection';
        $this->logger->warning($reason);
        $this->connection->disconnect(1001, $reason);
        $this->connection->resetSequence();

        $this->retrier->retry(3, function (int $i) {
            $this->logger->warning(sprintf('Forcefully reconnecting after invalid session, attempt %d.', $i));

            return $this->connection->connect(
                $this->connection->getDefaultUrl()
            );
        })->done(function () {
            $this->connection->getRawHandler()->registerOnce(IdentifyHelloEvent::class);
        }, function (Throwable $e) {
            $this->logger->critical('Unable to establish a new connection to Discord.', [$e]);
        });
    }
}
