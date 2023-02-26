<?php

declare(strict_types=1);

namespace Exan\Fenrir\Command;

use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;
use Exan\Fenrir\Websocket\Events\InteractionCreate;

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
