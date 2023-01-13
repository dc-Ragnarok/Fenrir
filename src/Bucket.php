<?php

namespace Exan\Dhp;

use Evenement\EventEmitter;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;

class Bucket extends EventEmitter
{
    private int $uses = 0;
    private array $queue = [];

    public function __construct(
        private LoopInterface $loop,
        private int $limit,
        private int $seconds
    ) {
        $this->on('DECREASE_USES', function () {
            $this->uses--;

            if (count($this->queue) !== 0) {
                $this->execute(array_shift($this->queue));
            }
        });
    }

    public function run(callable $action): Promise
    {
        return new Promise(function (callable $resolver, callable $reject) use ($action) {
            $wrappedAction = function () use ($action, $resolver, $reject) {
                try {
                    $result = $action();
                    $resolver($result);
                } catch (\Throwable $e) {
                    $reject($e);
                }
            };

            if ($this->uses === $this->limit) {
                $this->queue[] = $wrappedAction;
            } else {
                $this->execute($wrappedAction);
            }
        });
    }

    private function execute(callable $action)
    {
        $this->uses++;

        $action();

        $this->setTimer();
    }

    private function setTimer()
    {
        $this->loop->addTimer($this->seconds, function () {
            $this->emit('DECREASE_USES');
        });
    }
}
