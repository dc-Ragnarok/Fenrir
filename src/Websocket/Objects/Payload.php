<?php

namespace Exan\Dhp\Websocket\Objects;

class Payload
{
    public ?string $t;
    public ?int $s;
    public int $op;

    /**
     * @var mixed|null $d
     */
    public $d;
}
