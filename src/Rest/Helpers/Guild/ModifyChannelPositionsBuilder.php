<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class ModifyChannelPositionsBuilder
{
    use GetNew;

    private array $data = [];

    public function setId(string $id): self
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->data['id'] ?? null;
    }

    public function setPosition(int $position): self
    {
        $this->data['position'] = $position;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->data['position'] ?? null;
    }

    public function setLockPermissions(bool $lockPermissions): self
    {
        $this->data['lock_permissions'] = $lockPermissions;

        return $this;
    }

    public function getLockPermissions(): ?bool
    {
        return $this->data['lock_permissions'] ?? null;
    }

    public function setParentId(string $parentId): self
    {
        $this->data['parent_id'] = $parentId;

        return $this;
    }

    public function getParentId(): ?string
    {
        return $this->data['parent_id'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
