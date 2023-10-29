<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Scope;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class InstallParams
{
    /**
     * @var \Ragnarok\Fenrir\Enums\Scope[]
     */
    #[ArrayMapping(Scope::class)]
    public array $scopes;
    public string $permissions;
}
