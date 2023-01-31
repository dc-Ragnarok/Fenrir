<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetNsfw
{
    public function setNsfw(bool $nsfw): self
    {
        $this->data['nsfw'] = $nsfw;

        return $this;
    }
}
