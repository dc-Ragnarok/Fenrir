<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Bitwise;

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

    /**
     * @param BackedEnum<int>|int $flag
     */
    public function has(BackedEnum|int $flag): bool
    {
        $value = $flag instanceof BackedEnum ? $flag->value : $flag;

        return ($this->flags & $value) === $value;
    }

    public function getBitSet(): string
    {
        return decbin($this->flags);
    }

    /**
     * @param (BackedEnum<int>|int)[] ..$flags
     */
    public static function from(BackedEnum|int ...$flags): static
    {
        $bitwise = new static();

        foreach ($flags as $flag) {
            $bitwise->add($flag);
        }

        return $bitwise;
    }

    public static function fromBitSet(string $binary): static
    {
        return new static(bindec($binary));
    }
}
