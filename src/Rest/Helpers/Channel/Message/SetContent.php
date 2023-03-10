<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

trait SetContent
{
    /**
     * @var string $content Up to 2000 characters
     */
    public function setContent(string $content): self
    {
        $this->data['content'] = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->data['content'] ?? null;
    }
}
