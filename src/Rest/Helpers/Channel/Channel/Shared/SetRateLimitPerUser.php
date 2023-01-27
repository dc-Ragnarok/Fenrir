<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetRateLimitPerUser
{
    public function setRateLimitPerUser(int $duration): self
    {
        $this->data['rate_limit_per_user'] = min(max($duration, 0), 21600);

        return $this;
    }
}
