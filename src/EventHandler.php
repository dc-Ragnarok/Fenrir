<?php

namespace Exan\Dhp;

use Evenement\EventEmitter;
use Exan\Dhp\Const\Events;
use Exan\Dhp\Websocket\Events\ChannelPinsUpdate;
use Exan\Dhp\Websocket\Objects\Payload;
use JsonMapper;

class EventHandler extends EventEmitter
{
    private JsonMapper $mapper;

    public function __construct(private bool $raw = false)
    {
        $this->mapper = new JsonMapper();
    }

    public function handle(Payload $payload)
    {
        switch ($payload->t) {
            case Events::CHANNEL_PINS_UPDATE:
                $data = $this->mapper->map($payload->d, new ChannelPinsUpdate());
                var_dump($data);
        }

        if ($this->raw) {
            $this->emit(Events::RAW, [$payload]);
        }
    }
}
