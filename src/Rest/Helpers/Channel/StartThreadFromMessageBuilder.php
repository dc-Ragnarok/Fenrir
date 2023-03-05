<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Const\Validation\RateLimit;
use Ragnarok\Fenrir\Enums\Parts\ThreadAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class StartThreadFromMessageBuilder
{
    use GetNew;

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
