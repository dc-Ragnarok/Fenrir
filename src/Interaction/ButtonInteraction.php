<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Interaction;

use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;
use React\Promise\ExtendedPromiseInterface;

class ButtonInteraction
{
    public function __construct(public readonly InteractionCreate $interaction, private Discord $discord)
    {
    }

    public function createInteractionResponse(
        InteractionCallbackBuilder $interactionCallbackBuilder
    ): ExtendedPromiseInterface {
        return $this->discord->rest->webhook->createInteractionResponse(
            $this->interaction->id,
            $this->interaction->token,
            $interactionCallbackBuilder
        );
    }
}
