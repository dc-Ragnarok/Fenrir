<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetNsfw
{
    public function setNsfw(bool $nsfw): self
    {
        $this->data['nsfw'] = $nsfw;

        return $this;
    }
}
