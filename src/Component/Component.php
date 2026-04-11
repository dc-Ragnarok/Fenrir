<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component;

/** @deprecated */
abstract class Component
{
    abstract public function get(): array;
}
