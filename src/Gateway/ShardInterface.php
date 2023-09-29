<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

interface ShardInterface
{
    public function getShardSettings(): array;
}
