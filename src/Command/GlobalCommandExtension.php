<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;

/**
 * Emits an event for each Global Command used anywhere
 */
class GlobalCommandExtension extends CommandExtension
{
    public function __construct(?string $applicationId = null) {
        if (!is_null($applicationId)) {
            trigger_error('Providing an application ID is no longer required and will be removed in a later version');
        }
    }

    protected function emitInteraction(InteractionCreate $interaction): bool
    {
        return !isset($interaction->data->guild_id);
    }
}
