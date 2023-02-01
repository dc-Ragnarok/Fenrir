<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Message;

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
}
