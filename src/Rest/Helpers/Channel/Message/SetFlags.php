<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Message;

trait SetFlags
{
    public function setFlags(int $flags): self
    {
        $this->data['flags'] = $flags;
        return $this;
    }
}
