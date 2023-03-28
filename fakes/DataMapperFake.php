<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Ragnarok\Fenrir\DataMapper;
use Psr\Log\NullLogger;

class DataMapperFake
{
    /**
     * Returns a regular DataMapper with a NullLogger instead of a regular logger
     */
    public static function get(): DataMapper
    {
        return new DataMapper(
            new NullLogger()
        );
    }
}
