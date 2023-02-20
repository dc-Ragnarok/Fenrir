<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\Scopes;

class InstallParams
{
    /**
     * @var \Exan\Finrir\Enums\Parts\Scopes[]
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
