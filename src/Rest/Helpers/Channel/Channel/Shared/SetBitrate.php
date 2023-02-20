<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

trait SetBitrate
{
    public function setBitrate(int $bitrate): self
    {
        $this->data['bitrate'] = max($bitrate, 8000);

        return $this;
    }
}
