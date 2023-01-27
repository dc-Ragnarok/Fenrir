<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetNsfw
{
    function setNsfw(bool $nsfw): self
    {
        $this->data['nsfw'] = $nsfw;

        return $this;
    }
}
