<?php

declare(strict_types=1);

namespace Exan\Fenrir\Command;

use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Parts\ApplicationCommandOptionTypes as OptionTypes;
use Exan\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure as OptionStructure;
use Exan\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use React\Promise\ExtendedPromiseInterface;

class FiredCommand
{
    /** @var OptionStructure[] */
    private array $options = [];

    public function __construct(public readonly InteractionCreate $interaction, private Discord $discord)
    {
        /** @var OptionStructure[] */
        $options = $this->interaction->data->options ?? [];
        foreach ($options as $option) {
            $this->options[$option->name] = $option;
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

    public function getOption($option): ?OptionStructure
    {
        return $this->options[$option] ?? null;
    }

    public function hasOption($option): bool
    {
        return isset($this->options[$option]);
    }

    public function getSubCommandName(): ?string
    {
        return $this->getSubCommandNameFromOptions(
            $this->options
        );
    }

    /**
     * @param OptionStructure[] $options
     */
    private function getSubCommandNameFromOptions(array $options): ?string
    {
        $subItem = array_values(array_filter(
            $options,
            fn (OptionStructure $option) => in_array(
                $option->type,
                [OptionTypes::SUB_COMMAND, OptionTypes::SUB_COMMAND_GROUP]
            )
        ))[0] ?? null;

        if (is_null($subItem)) {
            return null;
        }

        return $subItem->type === OptionTypes::SUB_COMMAND
            ? $subItem->name
            : $subItem->name . ':' . $this->getSubCommandNameFromOptions($subItem->options);
    }
}
