<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

trait SetSystemChannelId
{
    public function setSystemChannelId(string $snowflake): static
    {
        $this->data['system_channel_id'] = $snowflake;

        return $this;
    }

    public function getSystemChannelId(): ?string
    {
        return $this->data['system_channel_id'] ?? null;
    }
}
