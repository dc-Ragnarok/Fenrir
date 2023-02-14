<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel\Message;

trait SetFlags
{
    public function setFlags(int $flags): self
    {
        $this->data['flags'] = $flags;
        return $this;
    }
}
