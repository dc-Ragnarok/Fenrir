<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Http;

use Discord\Http\Endpoint;
use React\Http\Browser;
use React\Promise\PromiseInterface;

class HttpClient
{
    private const BASE_URL = 'https://discord.com/api/';

    public function __construct(
        private readonly Browser $browser,
        private string $authorization,
    ) {
        echo 'Constructing HttpClient object', PHP_EOL;
    }

    public function request(
        Verb $verb,
        Endpoint $endpoint,
        array $headers,
        mixed $content,
    ): PromiseInterface {
        $defaultHeaders = [
            'Authorization' => $this->authorization,
        ];

        $encodedContent = $content === null ? '' : json_encode($content);
        if (!empty($encodedContent)) {
            $defaultHeaders['Content-Type'] = 'application/json';
        }

        return $this->browser->request(
            $verb->value,
            self::BASE_URL . $endpoint->toAbsoluteEndpoint(),
            [...$defaultHeaders, ...$headers],
            $encodedContent,
        );
    }

    public function __destruct()
    {
        echo 'Destructing HttpClient object', PHP_EOL;
    }
}
