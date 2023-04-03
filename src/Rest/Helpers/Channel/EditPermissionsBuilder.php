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
        $this->data['allow'] = $allow->getBitSet();

        return $this;
    }

    public function getAllow(): ?Bitwise
    {
        return isset($this->data['allow'])
            ? Bitwise::fromBitSet($this->data['allow'])
            : null;
    }

    public function setDeny(Bitwise $deny): self
    {
        $this->data['deny'] = $deny->getBitSet();

        return $this;
    }

    public function getDeny()
    {
        return isset($this->data['deny'])
            ? Bitwise::fromBitSet($this->data['deny'])
            : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
