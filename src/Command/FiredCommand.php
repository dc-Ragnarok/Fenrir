<?php

declare(strict_types=1);

namespace Exan\Fenrir\Command;

use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use React\Promise\ExtendedPromiseInterface;

class FiredCommand
{
    private array $options = [];

    public function __construct(public readonly InteractionCreate $interaction, private Discord $discord)
    {
        $options = $this->interaction->data->options ?? [];
        foreach ($options as $option) {
            $this->options[$option->name] = $option->value;
        }
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

    public function getInteractionResponse(): ExtendedPromiseInterface
    {
         return $this->discord->rest->webhook->getOriginalInteractionResponse(
             $this->interaction->application_id,
             $this->interaction->token
         );
    }

    public function editInteractionResponse(EditWebhookBuilder $webhookBuilder): ExtendedPromiseInterface
    {
        return $this->discord->rest->webhook->editOriginalInteractionResponse(
            $this->interaction->application_id,
            $this->interaction->token,
            $webhookBuilder
        );
    }

    public function deleteInteractionResponse(): ExtendedPromiseInterface
    {
        return $this->discord->rest->webhook->deleteOriginalInteractionResponse(
            $this->interaction->application_id,
            $this->interaction->token
        );
    }

    public function getOption($option): string|int|float|bool|null
    {
        return $this->options[$option] ?? null;
    }

    public function hasOption($option): bool
    {
        return isset($this->options[$option]);
    }
}
