<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Interaction;

use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType as OptionTypes;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure as OptionStructure;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use React\Promise\ExtendedPromiseInterface;

use function Freezemage\ArrayUtils\find as array_find;

class CommandInteraction
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

    public function getOption(string $path): ?OptionStructure
    {
        $segments = explode('.', $path);
        return $this->findOption($this->options, $segments);
    }

    private function findOption(array $options, array $segments): ?OptionStructure
    {
        $currentSegment = array_shift($segments);

        $option = array_find($options, fn (OptionStructure $option) => $option->name === $currentSegment);

        if (empty($segments)) {
            return $option;
        }

        return empty($option->options) ? null : $this->findOption($option->options, $segments);
    }

    public function hasOption(string $path): bool
    {
        $segments = explode('.', $path);
        return $this->findOption($this->options, $segments) !== null;
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
            static fn (OptionStructure $option) => in_array(
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
