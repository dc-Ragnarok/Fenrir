<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Const\Validation\RateLimit;
use Exan\Dhp\Enums\Parts\ThreadAutoArchiveDuration;

class StartThreadFromMessageBuilder
{
    private $data = [];

    public function setName(string $name): StartThreadFromMessageBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setAutoArchiveDuration(ThreadAutoArchiveDuration $duration): StartThreadFromMessageBuilder
    {
        $this->data['auto_archive_duration'] = $duration->value;

        return $this;
    }

    public function setRateLimitPerUser(int $seconds): StartThreadFromMessageBuilder
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
