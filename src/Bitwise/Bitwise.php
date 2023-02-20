<?php

declare(strict_types=1);

namespace Exan\Fenrir\Bitwise;

use BackedEnum;

class Bitwise
{
    public function __construct(private int $flags = 0)
    {
    }

    /**
     * @param BackedEnum<int>|int $flag
     */
    public function add(BackedEnum|int $flag): static
    {
        $value = $flag instanceof BackedEnum ? $flag->value : $flag;

        $this->flags |= $value;

        return $this;
    }

    public function get(): int
    {
        return $this->flags;
    }

    public function has(int $flag): bool
    {
        return ($this->flags & $flag) === $flag;
    }


    /**
     * @param (BackedEnum<int>|int)[] $flags
     */
    public static function from(BackedEnum|int ...$flags): static
    {
        $bitwise = new static();

        foreach ($flags as $flag) {
            $bitwise->add($flag);
        }

        return $bitwise;
    }
}
