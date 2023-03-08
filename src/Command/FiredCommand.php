<?php

declare(strict_types=1);

namespace Exan\Fenrir\Command;

use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Rest\Helpers\Webhook\WebhookBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use React\Promise\ExtendedPromiseInterface;

class FiredCommand
{
    public function __construct(public readonly InteractionCreate $interaction, private Discord $discord)
    {
    }

    public function createInteractionResponse(InteractionCallbackBuilder $interactionCallbackBuilder): ExtendedPromiseInterface
    {
        return $this->discord->rest->webhook->createInteractionResponse(
            $this->interaction->id,
            $this->interaction->token,
            $interactionCallbackBuilder
        );
    }

    public function createFollowUpMessage(WebhookBuilder $webhookBuilder)
    {
        return $this->discord->rest->webhook->editOriginalInteractionResponse(
            $this->interaction->application_id,
            $this->interaction->token,
            $webhookBuilder
        );
    }
}
