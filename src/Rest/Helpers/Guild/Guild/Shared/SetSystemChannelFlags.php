<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Bitwise\Bitwise;

trait SetSystemChannelFlags
{
    /**
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Flags\SystemChannelFlags> $flags
     */
    public function setSystemChannelFlags(Bitwise $flags): static
    {
        $this->data['system_channel_flags'] = $flags->get();

        return $this;
    }

    public function getSystemChannelFlags(): ?Bitwise
    {
        return isset($this->data['system_channel_flags'])
            ? new Bitwise($this->data['system_channel_flags'])
            : null;
    }
}
