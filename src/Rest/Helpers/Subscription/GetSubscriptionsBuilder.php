<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Subscription;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/subscription#list-sku-subscriptions
 */
class GetSubscriptionsBuilder
{
    use GetNew;

    private array $data = [];

    public function setBefore(string $before): self
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function getBefore(): ?string
    {
        return $this->data['before'] ?? null;
    }

    public function setAfter(string $after): self
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function getAfter(): ?string
    {
        return $this->data['after'] ?? null;
    }

    /**
     * @var int $limit Between 1 and 100, defaults to 50
     */
    public function setLimit(int $limit): self
    {
        $this->data['limit'] = $limit;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->data['limit'] ?? null;
    }

    public function setUserId(string $userId): self
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->data['user_id'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
