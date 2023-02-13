<?php

namespace Exan\Dhp\Parts;

use \Exan\Dhp\Enums\Parts\Scopes;

class InstallParams
{
    /**
     * @var \Exan\Dhp\Enums\Parts\Scopes[]
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
