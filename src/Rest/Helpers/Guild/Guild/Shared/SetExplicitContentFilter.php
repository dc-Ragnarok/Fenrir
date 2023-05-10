<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\Parts\ExplicitContentFilterLevels;

trait SetExplicitContentFilter
{
    public function setExplicitContentFilter(ExplicitContentFilterLevels $filter): static
    {
        $this->data['explicit_content_filter'] = $filter->value;

        return $this;
    }

    public function getExplicitContentFilter(): ?ExplicitContentFilterLevels
    {
        return isset($this->data['explicit_content_filter'])
            ? ExplicitContentFilterLevels::from($this->data['explicit_content_filter'])
            : null;
    }
}
