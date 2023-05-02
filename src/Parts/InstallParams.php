<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Parts\Scopes;

class InstallParams
{
    /**
     * @var Scopes[]
     */
    public array $scopes;
    public string $permissions;

    public function setScopes(array $value): void
    {
        $this->scopes = [];

        foreach ($value as $entry) {
            $this->scopes[] = Scopes::from($entry);
        }
    }
}
