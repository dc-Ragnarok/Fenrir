<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\ImageData;

trait SetIcon
{
    public function setIcon(string $content, ImageData $imageData): self
    {
        $this->data['icon'] = 'data:' . $imageData->value . ';base64,' . base64_encode($content);

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->data['icon'] ?? null;
    }
}
