<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetParentId
{
    public function setParentId(string $parentId): self
    {
        $this->data['parent_id'] = $parentId;

        return $this;
    }
}
