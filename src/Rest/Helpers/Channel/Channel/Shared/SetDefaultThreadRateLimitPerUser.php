<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Constants\Validation\RateLimit;

trait SetDefaultThreadRateLimitPerUser
{
    public function setDefaultThreadRateLimitPerUser(int $minutes): self
    {
        $this->data['default_thread_rate_limit_per_user'] = RateLimit::withinLimit($minutes);

        return $this;
    }

    public function getDefaultThreadRateLimitPerUser(): ?int
    {
        return $this->data['default_thread_rate_limit_per_user'] ?? null;
    }
}
