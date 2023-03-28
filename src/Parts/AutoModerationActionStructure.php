<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Parts\AutoModerationActionTypes;

class AutoModerationActionStructure
{
    public AutoModerationActionTypes $type;
    public ?AutoModerationActionMetadata $metadata;

    public function setType(int $value): void
    {
        $this->type = AutoModerationActionTypes::from($value);
    }
}
