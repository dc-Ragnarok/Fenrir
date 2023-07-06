<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Constants\Validation\RateLimit;
use Ragnarok\Fenrir\Enums\ChannelTypes;
use Ragnarok\Fenrir\Enums\ThreadAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class StartThreadWithoutMessageBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setAutoArchiveDuration(ThreadAutoArchiveDuration $duration): self
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

    public function setRateLimitPerUser(int $seconds): self
    {
        $this->data['rate_limit_per_user'] = RateLimit::withinLimit($seconds);

        return $this;
    }

    public function getRateLimitPerUser(): ?int
    {
        return $this->data['rate_limit_per_user'] ?? null;
    }

    public function setInvitable(bool $invitable): self
    {
        $this->data['invitable'] = $invitable;

        return $this;
    }

    public function getInvitable(): ?bool
    {
        return $this->data['invitable'] ?? null;
    }

    public function setType(ChannelTypes $type): self
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
