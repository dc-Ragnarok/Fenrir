<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class EditPermissionsBuilder
{
    use GetNew;

    private string $overwriteId;
    private array $data = [];

    public function setMemberId(string $memberId): self
    {
        $this->data['type'] = 1;
        $this->overwriteId = $memberId;

        return $this;
    }

    public function setRoleId(string $roleId): self
    {
        $this->data['type'] = 0;
        $this->overwriteId = $roleId;

        return $this;
    }

    public function getOverwriteId(): ?string
    {
        return $this->overwriteId ?? null;
    }

    public function setAllow(Bitwise $allow): self
    {
        $this->data['allow'] = (string) $allow->get();

        return $this;
    }

    public function getAllow(): ?Bitwise
    {
        return isset($this->data['allow'])
            ? new Bitwise((int) $this->data['allow'])
            : null;
    }

    public function setDeny(Bitwise $deny): self
    {
        $this->data['deny'] = (string) $deny->get();

        return $this;
    }

    public function getDeny(): ?Bitwise
    {
        return isset($this->data['deny'])
            ? new Bitwise((int) $this->data['deny'])
            : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
