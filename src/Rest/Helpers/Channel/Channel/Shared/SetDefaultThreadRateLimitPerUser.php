<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Const\Validation\RateLimit;

trait SetDefaultThreadRateLimitPerUser
{
    public function setDefaultThreadRateLimitPerUser(int $minutes): self
    {
        $this->data['default_thread_rate_limit_per_user'] = RateLimit::withinLimit($minutes);

        return $this;
    }
}
