<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Const\Validation\RateLimit;

trait SetRateLimitPerUser
{
    public function setRateLimitPerUser(int $seconds): self
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }
}
