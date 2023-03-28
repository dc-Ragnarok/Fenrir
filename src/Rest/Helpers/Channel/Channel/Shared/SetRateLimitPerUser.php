<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Constants\Validation\RateLimit;

trait SetRateLimitPerUser
{
    public function setRateLimitPerUser(int $seconds): self
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function getRateLimitPerUser(): ?int
    {
        return $this->data['rate_limit_per_user'] ?? null;
    }
}
