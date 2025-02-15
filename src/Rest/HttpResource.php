<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Http\Scheduler;
use React\Promise\PromiseInterface;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class HttpResource
{
    public function __construct(
        protected Scheduler $http,
        protected DataMapper $dataMapper,
        protected LoggerInterface $logger
    ) {
    }

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

    protected function getAuditLogReasonHeader(?string $reason = null): array
    {
        return is_null($reason) ? [] : ['X-Audit-Log-Reason' => rawurlencode($reason)];
    }
}
