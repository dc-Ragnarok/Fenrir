<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Closure;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;
use React\EventLoop\Loop;
use React\Promise\PromiseInterface;

use function React\Async\await;

class FilteredEventEmitter extends EventEmitter
{
    private Closure $listener;

    public function __construct(
        private EventEmitterInterface $eventEmitter,
        private string $event,
        private Closure $filter,
        private ?float $seconds = null,
        private ?int $maxItems = null,
    ) {
        $this->listener = function (...$args) {
            $output = ($this->filter)(...$args);

            $result = $output instanceof PromiseInterface
                ? await($output)
                : $output;

            if (!$result) {
                return;
            }

            $this->emit($this->event, $args);

            if (!is_null($this->maxItems)) {
                $this->maxItems--;

                if ($this->maxItems <= 0) {
                    $this->cancel();
                }
            }
        };
    }

    public function start()
    {
        $this->eventEmitter->on($this->event, $this->listener);

        if (!is_null($this->seconds)) {
            Loop::get()->addTimer($this->seconds, fn () => $this->cancel());
        }
    }

    public function cancel()
    {
        $this->eventEmitter->removeListener($this->event, $this->listener);
    }
}
