<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers;

use JsonMapper;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\PromiseInterface;

trait HttpHelper
{
    private JsonMapper $jsonMapper;

    protected function mapPromise(PromiseInterface $promise, string $class): ExtendedPromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->jsonMapper->map($data, new $class());
        });
    }

    protected function mapArrayPromise(PromiseInterface $promise, string $class): ExtendedPromiseInterface
    {
        return $promise->then(function ($data) use ($class) {
            return $this->jsonMapper->mapArray($data, [], $class);
        });
    }

    protected function getAuditLogReasonHeader(?string $reason = null): array
    {
        return is_null($reason) ? [] : ['X-Audit-Log-Reason' => $reason];
    }
}
