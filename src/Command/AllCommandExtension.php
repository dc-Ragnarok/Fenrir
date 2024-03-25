<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;

/**
 * Emits an event for Guild Commands and Global Commands
 */
class AllCommandExtension extends CommandExtension
{
    protected function emitInteraction(InteractionCreate $interaction): bool
    {
        return true;
    }
}
