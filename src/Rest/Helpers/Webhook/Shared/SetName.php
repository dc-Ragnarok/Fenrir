<?php

namespace Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared;

trait SetName
{
    public function setName(string $name): static
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }
}
