<?php

namespace Exan\Dhp\Rest\Helpers;

use JsonMapper;
use React\Promise\PromiseInterface;

trait HttpHelper
{
    private JsonMapper $jsonMapper;

    protected function mapPromise(PromiseInterface $promise, string $class)
    {
        return $promise->then(function ($data) use ($class) {
            return $this->jsonMapper->map($data, new $class());
        });
    }

    protected function getAuditLogReasonHeader(?string $reason = null): array
    {
        return is_null($reason) ? [] : ['X-Audit-Log-Reason' => $reason];
    }
}
