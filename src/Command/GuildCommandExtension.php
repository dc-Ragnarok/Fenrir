<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;

/**
 * Emits an event for each Guild Command used on a specific Guild
 */
class GuildCommandExtension extends CommandExtension
{
    public function __construct(private readonly string $guildId)
    {
    }

    protected function emitInteraction(InteractionCreate $interaction): bool
    {
        return isset($interaction->data->guild_id) && $interaction->data->guild_id === $this->guildId;
    }
}
