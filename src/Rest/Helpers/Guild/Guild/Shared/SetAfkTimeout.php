<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

trait SetAfkTimeout
{
    /**
     * @todo limit to allowed inputs
     */
    public function setAfkTimeout(int $timeout): static
    {
        $this->data['afk_timeout'] = $timeout;

        return $this;
    }

    public function getAfkTimeout(): ?int
    {
        return $this->data['afk_timeout'] ?? null;
    }
}
