<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

trait SetFlags
{
    public function setFlags(int $flags): self
    {
        $this->data['flags'] = $flags;

        return $this;
    }

    private function getFlags(): ?int
    {
        return isset($this->data['flags']) ? $this->data['flags'] : null;
    }
}
