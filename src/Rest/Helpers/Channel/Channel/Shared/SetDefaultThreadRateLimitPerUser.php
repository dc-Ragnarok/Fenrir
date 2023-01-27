<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetDefaultThreadRateLimitPerUser
{
    function setDefaultThreadRateLimitPerUser(int $limit): self
    {
        $this->data['default_thread_rate_limit_per_user'] = $limit;

        return $this;
    }
}
