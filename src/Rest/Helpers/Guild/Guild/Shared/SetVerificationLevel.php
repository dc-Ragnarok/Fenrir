<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\Parts\VerificationLevels;

trait SetVerificationLevel
{
    public function setVerificationLevel(VerificationLevels $level): static
    {
        $this->data['verification_level'] = $level->value;

        return $this;
    }

    public function getVerificationLevel(): ?VerificationLevels
    {
        return isset($this->data['verification_level'])
            ? VerificationLevels::from($this->data['verification_level'])
            : null;
    }
}
