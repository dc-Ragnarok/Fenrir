<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers\Traits;

use Exan\Retrier\Retrier;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyHelloEvent;
use Ragnarok\Fenrir\Gateway\Handlers\IdentifyResumeEvent;
use React\Promise\ExtendedPromiseInterface;

trait ReconnectsToGateway
{
    public function reconnect(ConnectionInterface $connection, LoggerInterface $logger, Retrier $retrier): ExtendedPromiseInterface
    {
        $connection->stopAutomaticHeartbeats();

        if (is_null($connection->getResumeUrl()) || is_null($connection->getSessionId())) {
            $reason = 'Unable to reconnect and resume session, attempting forceful reconnect';
            $logger->warning($reason);
            $connection->disconnect(1001, $reason);

            return $this->new($connection, $logger, $retrier);
        }

        $reason = 'Attempting reconnect';
        $logger->warning($reason);
        $connection->disconnect(1004, $reason);

        return $this->resume($connection, $logger, $retrier)->otherwise(function () use ($connection, $logger, $retrier) {
            $logger->error('Failed to reconnect and resume session, attempting forceful reconnect');

            return $this->new($connection, $logger, $retrier);
        });
    }

    private function resume(
        ConnectionInterface $connection,
        LoggerInterface $logger,
        Retrier $retrier
    ): ExtendedPromiseInterface {
        return $retrier->retry(3, function (int $i) use ($connection, $logger) {
            $logger->warning(sprintf('Reconnecting and resuming session, attempt %d.', $i));

            return $connection->connect($connection->getResumeUrl())->then(function () use ($connection) {
                $connection->getRawHandler()->registerOnce(IdentifyResumeEvent::class);
            });
        });
    }

    private function new(
        ConnectionInterface $connection,
        LoggerInterface $logger,
        Retrier $retrier
    ): ExtendedPromiseInterface {
        return $retrier->retry(3, function (int $i) use ($connection, $logger) {
            $logger->warning(sprintf('Forceful rennection attempt %d.', $i));

            return $connection->connect(
                $connection->getDefaultUrl()
            )->then(function () use ($connection) {
                $connection->getRawHandler()->registerOnce(IdentifyHelloEvent::class);
            });
        });
    }
}
