<?php

declare(strict_types=1);

namespace Exan\Fenrir\Constants\Validation\Traits;

trait WithinLimit
{
    public static function withinLimit(int $input)
    {
        return min(max($input, static::MIN), static::MAX);
    }
}
