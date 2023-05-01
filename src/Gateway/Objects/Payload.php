<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Objects;

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
