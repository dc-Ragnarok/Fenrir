<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

trait SetTts
{
    public function setTts(bool $tts): self
    {
        $this->data['tts'] = $tts;

        return $this;
    }
}
