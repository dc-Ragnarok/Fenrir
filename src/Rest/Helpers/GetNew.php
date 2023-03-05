<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers;

trait GetNew
{
    public static function new()
    {
        return new static();
    }
}
