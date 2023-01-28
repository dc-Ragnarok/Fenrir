<?php

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Const\Validation\RateLimit;

class StartThreadFromMessageBuilder
{
    private $data = [];

    public function setName(string $name): StartThreadFromMessageBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setAutoArchiveDuration(int $duration): StartThreadFromMessageBuilder
    {
        $this->data['auto_archive_duration'] = $duration;

        return $this;
    }

    public function setRateLimitPerUser(int $rateLimit): StartThreadFromMessageBuilder
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($rateLimit);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
