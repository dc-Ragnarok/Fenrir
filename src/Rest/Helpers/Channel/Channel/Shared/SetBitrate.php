<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetBitrate
{
    function setBitrate(int $bitrate): self
    {
        $this->data['bitrate'] = max($bitrate, 8000);

        return $this;
    }
}
