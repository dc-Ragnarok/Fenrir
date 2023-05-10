<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component;

abstract class Component
{
    abstract public function get(): array;
}
