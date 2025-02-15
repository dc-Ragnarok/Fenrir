<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Http;

use Discord\Http\Endpoint;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;

class Scheduler
{
    private array $processors = [];

    public function __construct(
        private readonly LoopInterface $loop,
        private readonly Client $client,
    ) {
    }

    public function request(Verb $verb, Endpoint $endpoint, ?array $content = null, array $headers = [])
    {
        $key = $endpoint->toAbsoluteEndpoint(true);

        if (!isset($this->processors[$key])) {
            $this->processors[$key] = new Processor($this->loop);
        }

        /** @var Processor */
        $processor = &$this->processors[$key];

        $processor->on(
            Processor::DESTRUCT,
            function () use ($key) {
                unset($this->processors[$key]);
            }
        );

        return new Promise(function (callable $resolver) use ($processor, $verb, $endpoint, $content, $headers) {
            $processor->queue(
                $resolver,
                new Job(
                    $this->client,
                    $verb,
                    $endpoint,
                    $content,
                    $headers,
                ),
            );

            $processor->start();
        });
    }
}
