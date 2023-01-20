<?php

declare(strict_types=1);

namespace Exan\Dhp\Component;

abstract class Component
{
    abstract public function get(): array;
}
