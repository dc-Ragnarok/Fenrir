<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

trait SetTopic
{
    public function setTopic(string $topic): self
    {
        $this->data['topic'] = $topic;

        return $this;
    }
}
