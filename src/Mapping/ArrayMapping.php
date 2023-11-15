<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayMapping
{
    /**
     * @param class-string $definition
     */
    public function __construct(public readonly string $definition)
    {
    }
}
