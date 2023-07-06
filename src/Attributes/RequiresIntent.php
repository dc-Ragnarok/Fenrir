<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Attributes;

use Attribute;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * Indicates related intents
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class RequiresIntent
{
    public function __construct(public readonly Intent $intent)
    {
    }
}
