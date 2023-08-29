<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Webhook;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared\SetAvatar;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared\SetName;

class ModifyWebhookBuilder
{
    use GetNew;
    use SetAvatar;
    use SetName;

    private array $data = [];

    public function setChannelId(string $channelId): static
    {
        $this->data['channel_id'] = $channelId;

        return $this;
    }

    public function getChannelId(): ?string
    {
        return $this->data['channel_id'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
