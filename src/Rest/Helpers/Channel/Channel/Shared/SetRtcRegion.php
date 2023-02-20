<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

trait SetRtcRegion
{
    public function setRtcRegion(string $rtcRegionId): self
    {
        $this->data['rtc_region'] = $rtcRegionId;

        return $this;
    }
}
