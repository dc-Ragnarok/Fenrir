<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers;

use Exan\Fenrir\DataMapper;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\PromiseInterface;

trait HttpHelper
{
    private DataMapper $dataMapper;

    protected function mapPromise(PromiseInterface $promise, string $class): ExtendedPromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->dataMapper->map($data, $class);
        });
    }

    protected function mapArrayPromise(PromiseInterface $promise, string $class): ExtendedPromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->dataMapper->mapArray($data, $class);
        });
    }

    protected function getAuditLogReasonHeader(?string $reason = null): array
    {
        return is_null($reason) ? [] : ['X-Audit-Log-Reason' => $reason];
    }
}
