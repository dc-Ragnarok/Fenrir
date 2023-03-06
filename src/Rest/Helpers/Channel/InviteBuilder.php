<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Rest\Helpers\GetNew;

class InviteBuilder
{
    use GetNew;

    private array $data = [];

    public function setMaxAge(int $maxAge): InviteBuilder
    {
        $this->data['max_age'] = min(max($maxAge, 0), 604800);

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return isset($this->data['max_age']) ? $this->data['max_age'] : null;
    }

    public function setMaxUses(int $maxUses): InviteBuilder
    {
        $this->data['max_uses'] = min(max($maxUses, 0), 100);

        return $this;
    }

    public function getMaxUses(): ?int
    {
        return isset($this->data['max_uses']) ? $this->data['max_uses'] : null;
    }

    public function setTemporary(bool $temporary): InviteBuilder
    {
        $this->data['temporary'] = $temporary;

        return $this;
    }

    public function getTemporary(): ?bool
    {
        return isset($this->data['temporary']) ? $this->data['temporary'] : null;
    }

    public function setUnique(bool $unique): InviteBuilder
    {
        $this->data['unique'] = $unique;

        return $this;
    }

    public function getUnique(): ?bool
    {
        return isset($this->data['unique']) ? $this->data['unique'] : null;
    }

    public function setTargetType(int $targetType): InviteBuilder
    {
        $this->data['target_type'] = $targetType;

        return $this;
    }

    public function getTargetType(): ?int
    {
        return isset($this->data['target_type']) ? $this->data['target_type'] : null;
    }

    public function setTargetUserId(string $targetUserId): InviteBuilder
    {
        $this->data['target_user_id'] = $targetUserId;

        return $this;
    }

    public function getTargetUserId(): ?string
    {
        return isset($this->data['target_user_id']) ? $this->data['target_user_id'] : null;
    }

    public function setTargetApplicationId(string $targetApplicationId): InviteBuilder
    {
        $this->data['target_application_id'] = $targetApplicationId;

        return $this;
    }

    public function getTargetApplicationId(): ?string
    {
        return isset($this->data['target_application_id']) ? $this->data['target_application_id'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
