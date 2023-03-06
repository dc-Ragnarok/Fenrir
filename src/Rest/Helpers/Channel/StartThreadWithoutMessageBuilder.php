<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Const\Validation\RateLimit;
use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Enums\Parts\ThreadAutoArchiveDuration;
use Exan\Fenrir\Rest\Helpers\GetNew;

class StartThreadWithoutMessageBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): StartThreadWithoutMessageBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return isset($this->data['name']) ? $this->data['name'] : null;
    }

    public function setAutoArchiveDuration(ThreadAutoArchiveDuration $duration): StartThreadWithoutMessageBuilder
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

    public function setRateLimitPerUser(int $seconds): StartThreadWithoutMessageBuilder
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function getRateLimitPerUser(): ?int
    {
        return isset($this->data['rate_limit_per_user']) ? $this->data['rate_limit_per_user'] : null;
    }

    public function setInvitable(bool $invitable): StartThreadWithoutMessageBuilder
    {
        $this->data['invitable'] = $invitable;

        return $this;
    }

    public function getInvitable(): ?bool
    {
        return isset($this->data['invitable']) ? $this->data['invitable'] : null;
    }

    public function setType(ChannelTypes $type): StartThreadWithoutMessageBuilder
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function getType(): ?ChannelTypes
    {
        return isset($this->data['type'])
            ? ChannelTypes::from($this->data['type'])
            : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
