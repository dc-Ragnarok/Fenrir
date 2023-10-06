<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Objects;

use JsonSerializable;

class Payload implements JsonSerializable
{
    public ?string $t;
    public ?int $s;
    public int $op;

    /**
     * @var mixed|null $d
     */
    public $d;

    public function jsonSerialize(): mixed {
        return [
            't' => $this->t,
            's' => $this->s,
            'op' => $this->op,
            'd' => $this->d,
        ];
    }
}
