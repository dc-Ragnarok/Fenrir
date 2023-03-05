<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetParentId
{
    public function setParentId(string $parentId): self
    {
        $this->data['parent_id'] = $parentId;

        return $this;
    }
}
