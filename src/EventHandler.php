<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Evenement\EventEmitter;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Websocket\Objects\Payload;

class EventHandler extends EventEmitter
{
    public function __construct(private DataMapper $mapper, private bool $raw = false)
    {
    }

    public function handle(Payload $payload)
    {
        if ($this->raw) {
            $this->emit(Events::RAW, [$payload]);
        }

        if (!$this->hasListener($payload->t)) {
            return;
        }

        if (!isset(Events::MAPPINGS[$payload->t])) {
            return;
        }

        $eventClass = Events::MAPPINGS[$payload->t];

        $this->emit(
            $payload->t,
            [
                $this->mapper->map(
                    $payload->d,
                    $eventClass
                )
            ]
        );
    }

    public function hasListener(string $event): bool
    {
        return isset($this->listeners[$event]) || isset($this->onceListeners[$event]);
    }
}
