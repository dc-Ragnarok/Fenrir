<?php

declare(strict_types=1);

namespace Exan\Dhp\Bitwise;

use BackedEnum;

class Bitwise
{
    public function __construct(private int $result = 0)
    {
    }

    /**
     * @param BackedEnum<int>|int $shiftedValue
     */
    public function add(BackedEnum|int $shiftedValue): static
    {
        $value = $shiftedValue instanceof BackedEnum ? $shiftedValue->value : $shiftedValue;

        $this->result |= $value;

        return $this;
    }

    public function get(): int
    {
        return $this->result;
    }

    public function has(int $shiftedValue): bool
    {
        return $this->result & $shiftedValue;
    }


    /**
     * @param (BackedEnum<int>|int)[] $values
     */
    public static function from(BackedEnum|int ...$values): static
    {
        $bitwise = new static();

        foreach ($values as $value) {
            $bitwise->add($value);
        }

        return $bitwise;
    }
}
