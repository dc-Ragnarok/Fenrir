<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

trait SetTopic
{
    public function setTopic(string $topic): self
    {
        $this->data['topic'] = $topic;

        return $this;
    }

    public function getTopic(): ?string
    {
        return isset($this->data['topic']) ? $this->data['topic'] : null;
    }
}
