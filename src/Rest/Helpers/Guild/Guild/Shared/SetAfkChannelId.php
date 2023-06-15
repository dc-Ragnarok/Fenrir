<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

trait SetAfkChannelId
{
    public function setAfkChannelId(string $snowflake): static
    {
        $this->data['afk_channel_id'] = $snowflake;

        return $this;
    }

    public function getAfkChannelId(): ?string
    {
        return $this->data['afk_channel_id'] ?? null;
    }
}
