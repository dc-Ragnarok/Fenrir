<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Mapping;

use Attribute;
use Closure;

#[Attribute(Attribute::TARGET_CLASS)]
class MapTo
{
    /**
     * @param Closure(object $source): null|class-string $definition
     */
    public function __construct(public readonly Closure $definition)
    {
    }
}
