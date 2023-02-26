<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Rest\Rest;

class Command
{
    public function __construct(private Rest $rest)
    {
        
    }
}
