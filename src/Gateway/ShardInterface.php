<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use DateInterval;

interface ShardInterface
{
    public function getShardSettings(): array;

    public function startDelay(): DateInterval;
}
