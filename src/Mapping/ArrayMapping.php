<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Mapping;

use Attribute;
use Closure;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayMapping
{
    /**
     * @param class-string|Closure(object $parent): class-string $definition
     */
    public function __construct(public readonly string|Closure $definition)
    {
    }
}
