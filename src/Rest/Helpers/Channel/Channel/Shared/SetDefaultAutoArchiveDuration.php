<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetDefaultAutoArchiveDuration
{
    public function setDefaultAutoArchiveDuration(int $minutes): self
    {
        $this->data['default_auto_archive_duration'] = $minutes;

        return $this;
    }
}
