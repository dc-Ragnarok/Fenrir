<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ActionType;

class AutoModerationActionStructure
{
    public ActionType $type;
    public ?AutoModerationActionMetadata $metadata;
}
