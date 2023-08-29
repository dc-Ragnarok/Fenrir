<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\GetBase64Image;

trait SetIcon
{
    use GetBase64Image;

    public function setIcon(string $content, ImageData $imageData): self
    {
        $this->data['icon'] = $this->getBase64Image($content, $imageData);

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->data['icon'] ?? null;
    }
}
