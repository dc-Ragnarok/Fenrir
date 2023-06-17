<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Extension;

use Ragnarok\Fenrir\Discord;

interface Extension
{
    public function initialize(Discord $discord): void;
}
