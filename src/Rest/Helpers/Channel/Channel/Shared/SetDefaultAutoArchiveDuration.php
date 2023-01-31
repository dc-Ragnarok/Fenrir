<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetDefaultAutoArchiveDuration
{
    public function setDefaultAutoArchiveDuration(int $minutes): self
    {
        $this->data['default_auto_archive_duration'] = $minutes;

        return $this;
    }
}
