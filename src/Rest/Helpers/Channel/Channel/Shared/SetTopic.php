<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

trait SetTopic
{
    public function setTopic(string $topic): self
    {
        $this->data['topic'] = $topic;

        return $this;
    }
}
