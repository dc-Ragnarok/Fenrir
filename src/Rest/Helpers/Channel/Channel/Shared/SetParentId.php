<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetParentId
{
    public function setParentId(string $parentId): self
    {
        $this->data['parent_id'] = $parentId;

        return $this;
    }

    public function getParentId(): ?string
    {
        return isset($this->data['parent_id']) ? $this->data['parent_id'] : null;
    }
}
