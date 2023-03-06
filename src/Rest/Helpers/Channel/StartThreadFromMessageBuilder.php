<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Const\Validation\RateLimit;
use Exan\Fenrir\Enums\Parts\ThreadAutoArchiveDuration;
use Exan\Fenrir\Rest\Helpers\GetNew;

class StartThreadFromMessageBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): StartThreadFromMessageBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return isset($this->data['name']) ? $this->data['name'] : null;
    }

    public function setAutoArchiveDuration(ThreadAutoArchiveDuration $duration): StartThreadFromMessageBuilder
    {
        $this->data['auto_archive_duration'] = $duration->value;

        return $this;
    }

    public function getAutoArchiveDuration(): ?ThreadAutoArchiveDuration
    {
        return isset($this->data['auto_archive_duration'])
            ? ThreadAutoArchiveDuration::from($this->data['auto_archive_duration'])
            : null;
    }

    public function setRateLimitPerUser(int $seconds): StartThreadFromMessageBuilder
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function getRateLimitPerUser(): ?int
    {
        return isset($this->data['rate_limit_per_user']) ? $this->data['rate_limit_per_user'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
