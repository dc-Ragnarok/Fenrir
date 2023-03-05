<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\Command\InteractionCallbackTypes;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;

class FiredCommand
{
    public function __construct(public readonly InteractionCreate $interaction, private Discord $discord)
    {
    }

    public function sendFollowUpMessage(InteractionCallbackBuilder $interactionCallbackBuilder)
    {
        return $this->discord->rest->webhook->createFollowUpMessage(
            $this->interaction->id,
            $this->interaction->token,
            $interactionCallbackBuilder
        );
    }
}
