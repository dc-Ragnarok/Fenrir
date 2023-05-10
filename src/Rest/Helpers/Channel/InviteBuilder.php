<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class InviteBuilder
{
    use GetNew;

    private array $data = [];

    public function setMaxAge(int $maxAge): self
    {
        $this->data['max_age'] = min(max($maxAge, 0), 604800);

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->data['max_age'] ?? null;
    }

    public function setMaxUses(int $maxUses): self
    {
        $this->data['max_uses'] = min(max($maxUses, 0), 100);

        return $this;
    }

    public function getMaxUses(): ?int
    {
        return $this->data['max_uses'] ?? null;
    }

    public function setTemporary(bool $temporary): self
    {
        $this->data['temporary'] = $temporary;

        return $this;
    }

    public function getTemporary(): ?bool
    {
        return $this->data['temporary'] ?? null;
    }

    public function setUnique(bool $unique): self
    {
        $this->data['unique'] = $unique;

        return $this;
    }

    public function getUnique(): ?bool
    {
        return $this->data['unique'] ?? null;
    }

    public function setTargetType(int $targetType): self
    {
        $this->data['target_type'] = $targetType;

        return $this;
    }

    public function getTargetType(): ?int
    {
        return $this->data['target_type'] ?? null;
    }

    public function setTargetUserId(string $targetUserId): self
    {
        $this->data['target_user_id'] = $targetUserId;

        return $this;
    }

    public function getTargetUserId(): ?string
    {
        return $this->data['target_user_id'] ?? null;
    }

    public function setTargetApplicationId(string $targetApplicationId): self
    {
        $this->data['target_application_id'] = $targetApplicationId;

        return $this;
    }

    public function getTargetApplicationId(): ?string
    {
        return $this->data['target_application_id'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
