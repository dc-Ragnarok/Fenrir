<?php

namespace Exan\Dhp\Websocket\Events;

class StageInstanceCreate
{
    public string $token;
    public string $guild_id;
    public ?string $endpoint;
}
