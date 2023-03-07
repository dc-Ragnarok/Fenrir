<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetBitrate
{
    public function setBitrate(int $bitrate): self
    {
        $this->data['bitrate'] = max($bitrate, 8000);

        return $this;
    }

    public function getBitrate(): ?int
    {
        return $this->data['bitrate'] ?? null;
    }
}
