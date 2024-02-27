<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Evenement\EventEmitter;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Enums\InteractionType;
use Ragnarok\Fenrir\Extension\Extension;
use Ragnarok\Fenrir\FilteredEventEmitter;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure;

use function Freezemage\ArrayUtils\find;

abstract class CommandExtension extends EventEmitter implements Extension
{
    protected array $commandMappings = [];

    protected FilteredEventEmitter $commandListener;

    abstract protected function loadExistingCommands(Discord $discord): void;

    public function initialize(Discord $discord): void
    {
        $this->loadExistingCommands($discord);

        $this->registerListener($discord);
    }

    private function registerListener(Discord $discord): void
    {
        $this->commandListener = new FilteredEventEmitter(
            $discord->gateway->events,
            Events::INTERACTION_CREATE,
            fn (InteractionCreate $interactionCreate) =>
                $interactionCreate?->type === InteractionType::APPLICATION_COMMAND
                && isset($this->commandMappings[$interactionCreate->data->id])
        );

        $this->commandListener->on(Events::INTERACTION_CREATE, function (InteractionCreate $interaction) use ($discord) {
            $this->handleInteraction($interaction, $discord);
        });

        $this->commandListener->start();
    }

    private function handleInteraction(InteractionCreate $interaction, Discord $discord)
    {
        $firedCommand = new CommandInteraction($interaction, $discord);

        $this->emit($this->commandMappings[$interaction->data->id], [$firedCommand]);
    }

    protected function getFullNameByCommand(ApplicationCommand $command): string
    {
        $names = [$command->name];

        $this->drillName($command->options ?? [], $names);

        return implode('.', $names);
    }

    private function drillName(array $options, array &$names)
    {
        /** @var ?ApplicationCommandOptionStructure */
        $subCommand = find($options ?? [], function (ApplicationCommandOptionStructure $option) {
            return in_array(
                $option->type,
                [
                    ApplicationCommandOptionType::SUB_COMMAND,
                    ApplicationCommandOptionType::SUB_COMMAND_GROUP,
                ]
            );
        });

        if (!is_null($subCommand)) {
            $names[] = $subCommand->name;

            $this->drillName($subCommand->options ?? [], $names);
        }
    }
}
