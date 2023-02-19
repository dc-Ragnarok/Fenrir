<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Const\Validation\RateLimit;
use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Enums\Parts\ThreadAutoArchiveDuration;

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
