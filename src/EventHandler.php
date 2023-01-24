<?php

declare(strict_types=1);

namespace Exan\Dhp;

use Evenement\EventEmitter;
use Exan\Dhp\Const\Events;
use Exan\Dhp\Websocket\Objects\Payload;
use JsonMapper;

class EventHandler extends EventEmitter
{
    public function __construct(private JsonMapper $mapper, private bool $raw = false)
    {
    }

    public function handle(Payload $payload)
    {
        if ($this->raw) {
            $this->emit(Events::RAW, [$payload]);
        }

        if (!isset(Events::MAPPINGS[$payload->t])) {
            return;
        }

        $eventClass = Events::MAPPINGS[$payload->t];

        $this->emit($payload->t, [$this->mapper->map($payload->d, new $eventClass())]);
    }
}
