<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Enums\ComponentV2Type;
use Ragnarok\Fenrir\Mapping\MapTo;

#[MapTo(static function (mixed $source) {
    $type = $source->type ?? -1;
    return ComponentV2Type::tryFrom($type)?->getClass();
})]
class Component
{
    public int $type;
    public ?int $id;
}
