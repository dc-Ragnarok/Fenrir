<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\ExplicitContentFilterLevel;

trait SetExplicitContentFilter
{
    public function setExplicitContentFilter(ExplicitContentFilterLevel $filter): static
    {
        $this->data['explicit_content_filter'] = $filter->value;

        return $this;
    }

    public function getExplicitContentFilter(): ?ExplicitContentFilterLevel
    {
        return isset($this->data['explicit_content_filter'])
            ? ExplicitContentFilterLevel::from($this->data['explicit_content_filter'])
            : null;
    }
}
