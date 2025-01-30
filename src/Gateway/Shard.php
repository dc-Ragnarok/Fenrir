<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use DateInterval;

class Shard implements ShardInterface
{
    public function __construct(private int $shardId, private int $numShards)
    {
    }

    public function getShardSettings(): array
    {
        return [$this->shardId, $this->numShards];
    }

    public function startDelay(): DateInterval
    {
        return new DateInterval('PT10S');
    }
}
