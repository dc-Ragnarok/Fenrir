<?php

namespace Exan\Dhp\Rest;

use JsonMapper;
use React\Promise\PromiseInterface;

trait MapPromises
{
    private JsonMapper $jsonMapper;

    public function mapPromise(PromiseInterface $promise, string $class)
    {
        return $promise->then(function ($data) use ($class) {
            return $this->jsonMapper->map($data, new $class);
        });
    }
}
