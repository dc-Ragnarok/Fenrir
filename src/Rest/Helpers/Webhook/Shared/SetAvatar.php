<?php

namespace Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared;

use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\GetBase64Image;

trait SetAvatar
{
    use GetBase64Image;

    public function setAvatar(string $content, ImageData $imageData): static
    {
        $this->data['avatar'] = $this->getBase64Image($content, $imageData);

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->data['avatar'] ?? null;
    }
}
