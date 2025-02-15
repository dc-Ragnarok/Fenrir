<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Http;

use Discord\Http\Endpoint;
use React\Promise\PromiseInterface;

class Job
{
    public function __construct(
        private readonly Client $client,
        private readonly Verb $verb,
        private readonly Endpoint $endpoint,
        private readonly ?array $content,
        private readonly mixed $headers,
    ) {
    }

    public function execute(): PromiseInterface
    {
        return $this->client->request(
            $this->verb,
            $this->endpoint,
            $this->headers,
            $this->content,
        );
    }
}
