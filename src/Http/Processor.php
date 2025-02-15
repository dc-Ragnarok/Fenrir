<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Http;

use Carbon\Carbon;
use Evenement\EventEmitter;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;

class Processor extends EventEmitter
{
    public const DESTRUCT = 'destruct';

    private const HEADER_LIMIT = 'X-RateLimit-Limit';
    private const HEADER_REMAINING = 'X-RateLimit-Remaining';
    private const HEADER_RESET = 'X-RateLimit-Reset';
    private const HEADER_RESET_AFTER = 'X-RateLimit-Reset-After';
    private const HEADER_BUCKET = 'X-RateLimit-Bucket';

    private bool $started = false;
    private bool $initialized = false;
    private bool $isProcessing = false;

    private array $queue = [];

    private int $limit;
    private int $remaining;
    private Carbon $reset;
    private float $resetAfter;
    private string $bucket;
    private string $scope;

    public function __construct(
        private readonly LoopInterface $loop,
    ) {
    }

    public function queue(
        callable $resolver,
        Job $job,
    ): void {
        $this->queue[] = [$resolver, $job];
    }

    public function start()
    {
        if ($this->started) {
            if ($this->initialized) {
                $this->process();
            }

            return;
        }

        $this->started = true;

        $this->continue();
    }

    private function continue()
    {
        /**
         * @var callable $resolver
         * @var Job $job
         */
        [$resolver, $job] = array_shift($this->queue);

        $job->execute()
            ->then(function (ResponseInterface $response) use ($resolver) {
                $this->resolve($resolver, $response);

                $this->limit = (int) $response->getHeader(self::HEADER_LIMIT)[0];
                $this->remaining = (int) $response->getHeader(self::HEADER_REMAINING)[0];
                $this->reset = Carbon::createFromTimestamp($response->getHeader(self::HEADER_RESET)[0]);
                $this->resetAfter = (float) $response->getHeader(self::HEADER_RESET_AFTER)[0];
                $this->bucket = $response->getHeader(self::HEADER_BUCKET)[0];

                $this->initialized = true;

                $this->loop->addTimer($this->resetAfter, function () {
                    if (empty($this->queue)) {
                        $this->emit(self::DESTRUCT);
                        return;
                    }

                    $this->continue();
                });

                $this->process();
            });
    }



    private function process()
    {
        if ($this->isProcessing) {
            return;
        }

        $this->isProcessing = true;

        while ($this->remaining > 0 && !empty($this->queue)) {
            $this->remaining--;

            /**
             * @var callable $resolver
             * @var Job $job
             */
            [$resolver, $job] = array_shift($this->queue);

            $job->execute()
                ->then(function (ResponseInterface $response) use ($resolver) {
                    $this->resolve($resolver, $response);
                });
        }

        $this->isProcessing = false;
    }

    private function resolve(callable $resolver, ResponseInterface $response): void
    {
        $body = (string) $response->getBody();

        $result = $body === ''
            ? null
            : json_decode($body);

        $resolver($result);
    }
}
