<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Http;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\DataMapper;
use React\Promise\PromiseInterface;
use Throwable;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class HttpResource
{
    public function __construct(
        protected Http $http,
        protected DataMapper $dataMapper,
        protected LoggerInterface $logger
    ) {}

    protected function mapPromise(PromiseInterface $promise, string $class): PromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->dataMapper->map($data, $class);
        });
    }

    protected function mapArrayPromise(PromiseInterface $promise, string $class): PromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->dataMapper->mapArray($data, $class);
        });
    }

    protected function logThrowable(Throwable $e): void
    {
        $this->logger->error($e->getMessage());
    }

    protected function getAuditLogReasonHeader(?string $reason = null): array
    {
        return is_null($reason) ? [] : ['X-Audit-Log-Reason' => rawurlencode($reason)];
    }
}
