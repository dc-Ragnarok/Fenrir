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
        return $this->data['tts'] ?? null;
    }
}
