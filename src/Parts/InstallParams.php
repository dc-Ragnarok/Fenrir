<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Scope;

class InstallParams
{
    /**
     * @var \Ragnarok\Fenrir\Enums\Scope[]
     */
    public array $scopes;
    public string $permissions;

    public function setScopes(array $value): void
    {
        $this->scopes = [];

        foreach ($value as $entry) {
            $this->scopes[] = Scope::from($entry);
        }
    }
}
