<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Entitlement;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/entitlement#list-entitlements
 */
class GetEntitlementsBuilder
{
    use GetNew;

    private array $data = [];

    public function setUserId(string $userId): self
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->data['user_id'] ?? null;
    }

    /**
     * @param string[] $skuIds Discord expects these comma delimited
     */
    public function setSkuIds(array $skuIds): self
    {
        $this->data['sku_ids'] = implode(',', $skuIds);

        return $this;
    }

    public function getSkuIds(): ?string
    {
        return $this->data['sku_ids'] ?? null;
    }

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

    public function setLimit(int $limit): self
    {
        $this->data['limit'] = $limit;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->data['limit'] ?? null;
    }

    public function setGuildId(string $guildId): self
    {
        $this->data['guild_id'] = $guildId;

        return $this;
    }

    public function getGuildId(): ?string
    {
        return $this->data['guild_id'] ?? null;
    }

    public function setExcludeEnded(bool $excludeEnded): self
    {
        $this->data['exclude_ended'] = $excludeEnded;

        return $this;
    }

    public function getExcludeEnded(): ?bool
    {
        return $this->data['exclude_ended'] ?? null;
    }

    public function setExcludeDeleted(bool $excludeDeleted): self
    {
        $this->data['exclude_deleted'] = $excludeDeleted;

        return $this;
    }

    public function getExcludeDeleted(): ?bool
    {
        return $this->data['exclude_deleted'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
