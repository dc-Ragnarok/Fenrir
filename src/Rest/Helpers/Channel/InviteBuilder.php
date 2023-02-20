<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel;

class InviteBuilder
{
    private $data = [];

    public function setMaxAge(int $maxAge): InviteBuilder
    {
        $this->data['max_age'] = min(max($maxAge, 0), 604800);

        return $this;
    }

    public function setMaxUses(int $maxUses): InviteBuilder
    {
        $this->data['max_uses'] = min(max($maxUses, 0), 100);

        return $this;
    }

    public function setTemporary(bool $temporary): InviteBuilder
    {
        $this->data['temporary'] = $temporary;

        return $this;
    }

    public function setUnique(bool $unique): InviteBuilder
    {
        $this->data['unique'] = $unique;

        return $this;
    }

    public function setTargetType(int $targetType): InviteBuilder
    {
        $this->data['target_type'] = $targetType;

        return $this;
    }

    public function setTargetUserId(string $targetUserId): InviteBuilder
    {
        $this->data['target_user_id'] = $targetUserId;

        return $this;
    }

    public function setTargetApplicationId(string $targetApplicationId): InviteBuilder
    {
        $this->data['target_application_id'] = $targetApplicationId;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
