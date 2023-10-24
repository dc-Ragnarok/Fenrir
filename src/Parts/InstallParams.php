<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Scope;

class InstallParams
{
    /**
     * @var \Ragnarok\Fenrir\Enums\Scope[]
     * @todo Enum array
     */
    public array $scopes;
    public string $permissions;
}
