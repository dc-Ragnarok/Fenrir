<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetRtcRegion
{
    public function setRtcRegion(string $rtcRegionId): self
    {
        $this->data['rtc_region'] = $rtcRegionId;

        return $this;
    }

    public function getRtcRegion(): ?string
    {
        return isset($this->data['rtc_region']) ? $this->data['rtc_region'] : null;
    }
}
