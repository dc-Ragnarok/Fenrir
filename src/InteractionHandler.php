<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Component\Button\InteractionButton;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Enums\Parts\InteractionTypes;
use Ragnarok\Fenrir\Interaction\ButtonInteraction;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;
use Ragnarok\Fenrir\Websocket\Events\Ready;

class InteractionHandler
{
    private FilteredEventEmitter $commandListener;
    private FilteredEventEmitter $buttonListener;

    /** @var array<string, callable> */
    private array $handlersCommand = [];

    /** @var array<string, callable> */
    private array $handlersButton = [];

    private bool $devMode = false;

    public function __construct(private Discord $discord, private ?string $devGuildId = null)
    {
        if (!is_null($this->devGuildId)) {
            $this->devMode = true;
        }
    }

    public function registerCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        if ($this->devMode) {
            $this->registerGuildCommand($commandBuilder, $this->devGuildId, $handler);
        } else {
            $this->registerGlobalCommand($commandBuilder, $handler);
        }
    }

    public function registerGuildCommand(CommandBuilder $commandBuilder, string $guildId, callable $handler): void
    {
        $this->activateCommandListener();

        /** Ready event includes Application ID */
        $this->discord->gateway->events->once(
            Events::READY,
            function (Ready $ready) use ($commandBuilder, $guildId, $handler) {
                $this->discord->rest->guildCommand->createApplicationCommand(
                    $ready->user->id,
                    $guildId,
                    $commandBuilder
                )->then(function (ApplicationCommand $applicationCommand) use ($handler) {
                    $this->handlersCommand[$applicationCommand->id] = $handler;
                });
            }
        );
    }

    public function registerGlobalCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        $this->activateCommandListener();

        /** Ready event includes Application ID */
        $this->discord->gateway->events->once(Events::READY, function (Ready $ready) use ($commandBuilder, $handler) {
            $this->discord->rest->globalCommand->createApplicationCommand(
                $ready->user->id,
                $commandBuilder
            )->then(function (ApplicationCommand $applicationCommand) use ($handler) {
                $this->handlersCommand[$applicationCommand->id] = $handler;
            });
        });
    }

    private function activateCommandListener()
    {
        if (isset($this->commandListener)) {
            return;
        }

        $this->commandListener = new FilteredEventEmitter(
            $this->discord->gateway->events,
            Events::INTERACTION_CREATE,
            fn (InteractionCreate $interactionCreate) =>
                $interactionCreate->type === InteractionTypes::APPLICATION_COMMAND
        );

        $this->commandListener->on(Events::INTERACTION_CREATE, $this->handleCommandInteraction(...));

        $this->commandListener->start();
    }

    private function handleCommandInteraction(InteractionCreate $interactionCreate)
    {
        if (!isset($this->handlersCommand[$interactionCreate->data->id])) {
            return;
        }

        $firedCommand = new CommandInteraction($interactionCreate, $this->discord);

        $this->handlersCommand[$interactionCreate->data->id]($firedCommand);
    }

    public function onButtonInteraction(InteractionButton $interactionButton, callable $action)
    {
        $this->activateButtonListener();

        $this->handlersButton[$interactionButton->customId] = $action;
    }

    private function activateButtonListener()
    {
        if (isset($this->buttonListener)) {
            return;
        }

        $this->buttonListener = new FilteredEventEmitter(
            $this->discord->gateway->events,
            Events::INTERACTION_CREATE,
            fn (InteractionCreate $interactionCreate) =>
            $interactionCreate->type === InteractionTypes::MESSAGE_COMPONENT
                && $interactionCreate->data->component_type === 2 // @todo enum
        );

        $this->buttonListener->on(Events::INTERACTION_CREATE, $this->handleButtonInteraction(...));

        $this->buttonListener->start();
    }

    private function handleButtonInteraction(InteractionCreate $interactionCreate)
    {
        if (!isset($this->handlersButton[$interactionCreate->data->custom_id])) {
            return;
        }

        $buttonInteraction = new ButtonInteraction($interactionCreate, $this->discord);

        $remove = $this->handlersButton[$interactionCreate->data->custom_id]($buttonInteraction);

        if ($remove) {
            unset($this->handlersButton[$interactionCreate->data->custom_id]);
        }
    }
}
