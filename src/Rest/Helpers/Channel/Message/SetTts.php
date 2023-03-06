<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

trait SetTts
{
    public function setTts(bool $tts): self
    {
        $this->data['tts'] = $tts;

        return $this;
    }

    public function getTts(): ?bool
    {
        return isset($this->data['tts']) ? $this->data['tts'] : null;
    }
}
