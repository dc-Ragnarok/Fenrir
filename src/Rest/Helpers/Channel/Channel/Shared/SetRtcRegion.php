<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetRtcRegion
{
    public function setRtcRegion(string $rtcRegionId): self
    {
        $this->data['rtc_region'] = $rtcRegionId;

        return $this;
    }
}
