<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Command;

use Closure;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;

class QueuedCommand
{
    public function __construct(
        public readonly CommandBuilder $commandBuilder,
        public readonly Closure $handler,
        public readonly ?string $guildId = null
    ) {
    }

    public function isGlobalCommand(): bool
    {
        return ($this->guildId === null);
    }
}
