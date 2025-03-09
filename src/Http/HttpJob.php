<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Http;

use Discord\Http\Endpoint;
use React\Promise\PromiseInterface;

class HttpJob
{
    public function __construct(
        private readonly HttpClient $client,
        private readonly Verb $verb,
        private readonly Endpoint $endpoint,
        private readonly ?array $content,
        private readonly mixed $headers,
    ) {
        echo 'Constructing HttpJob object', PHP_EOL;
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

    public function __destruct()
    {
        echo 'Destructing HttpJob object', PHP_EOL;
    }
}
