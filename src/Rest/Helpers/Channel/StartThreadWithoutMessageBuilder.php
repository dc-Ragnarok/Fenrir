<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Const\Validation\RateLimit;
use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Enums\Parts\ThreadAutoArchiveDuration;

class StartThreadWithoutMessageBuilder
{
    private $data = [];

    public function setName(string $name): StartThreadWithoutMessageBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setAutoArchiveDuration(ThreadAutoArchiveDuration $duration): StartThreadWithoutMessageBuilder
    {
        $this->data['auto_archive_duration'] = $duration->value;

        return $this;
    }

    public function setRateLimitPerUser(int $seconds): StartThreadWithoutMessageBuilder
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function setInvitable(bool $invitable): StartThreadWithoutMessageBuilder
    {
        $this->data['invitable'] = $invitable;

        return $this;
    }

    public function setType(ChannelTypes $type): StartThreadWithoutMessageBuilder
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
