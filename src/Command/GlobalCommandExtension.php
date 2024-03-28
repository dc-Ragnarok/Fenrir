<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;

/**
 * Emits an event for each Global Command used anywhere
 */
class GlobalCommandExtension extends CommandExtension
{
    protected function emitInteraction(InteractionCreate $interaction): bool
    {
        return !isset($interaction->data->guild_id);
    }
}
