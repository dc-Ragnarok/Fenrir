<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers;

trait GetNew
{
    public static function new(): static
    {
        return new static();
    }
}
