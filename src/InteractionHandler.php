<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Closure;
use Ragnarok\Fenrir\Component\Button\InteractionButton;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Enums\Parts\InteractionTypes;
use Ragnarok\Fenrir\Interaction\ButtonInteraction;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Command\QueuedCommand;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;
use Ragnarok\Fenrir\Websocket\Events\Ready;
use Throwable;

class InteractionHandler
{
    private FilteredEventEmitter $commandListener;
    private FilteredEventEmitter $buttonListener;
    private string $applicationId;
    private bool $devMode = false;

    /** @var array<string, callable> */
    private array $handlersCommand = [];

    /** @var array<string, callable> */
    private array $handlersButton = [];

    /** @var QueuedCommand[] */
    private array $commandQueue = [];

    /** @var string[] */
    private array $guildsToCheck = [];

    public function __construct(private Discord $discord, private ?string $devGuildId = null)
    {
        if (!is_null($this->devGuildId)) {
            $this->devMode = true;
        }

        $this->discord->gateway->events->once(
            Events::READY,
            function (Ready $ready) {
                $this->applicationId = $ready->user->id;

                $compareCommands = function (array $commands, bool $globalCommands) {
                    foreach ($this->commandQueue as $queuedCommand) {
                        if ($globalCommands && ($queuedCommand->guildId !== null)) {
                            return;
                        }

                        $needsRegistered = true;

                        foreach ($commands as $command) {
                            if ($queuedCommand->commandBuilder->matchesApplicationCommand($command) === true) {
                                $needsRegistered = false;
                                break;
                            }
                        }

                        if (!$needsRegistered) {
                            continue;
                        }

                        if ($queuedCommand->guildId === null) {
                            $this->registerGlobalCommand($queuedCommand->commandBuilder, $queuedCommand->handler);
                        } else {
                            $this->registerGuildCommand(
                                $queuedCommand->commandBuilder,
                                $queuedCommand->guildId,
                                $queuedCommand->handler
                            );
                        }
                    }
                };

                $this->discord->rest->globalCommand->getApplicationCommands($this->applicationId)
                    ->then(function (array $commands) use ($compareCommands) {
                        $compareCommands($commands, true);
                    })
                ;

                foreach ($this->guildsToCheck as $guildId) {
                    $this->discord->rest->guildCommand->getApplicationCommands($this->applicationId, $guildId)
                        ->then(function (array $commands) use ($compareCommands) {
                            $compareCommands($commands, false);
                        })
                    ;
                }
            }
        );
    }

    public function registerCommand(CommandBuilder $commandBuilder, Closure $handler): void
    {
        $this->activateCommandListener();

        if ($this->devMode) {
            $this->registerGuildCommand($commandBuilder, $this->devGuildId, $handler);

            return;
        }

        $this->registerGlobalCommand($commandBuilder, $handler);
    }

    public function registerGuildCommand(CommandBuilder $commandBuilder, string $guildId, Closure $handler): void
    {
        if (!isset($this->applicationId)) {
            if (!in_array($guildId, $this->guildsToCheck)) {
                $this->guildsToCheck[] = $guildId;
            }

            $this->commandQueue[] = new QueuedCommand($commandBuilder, $handler, $guildId);
            return;
        }

        $this->activateCommandListener();

        $this->discord->rest->guildCommand->createApplicationCommand(
            $this->applicationId,
            $guildId,
            $commandBuilder
        )->then(function (ApplicationCommand $applicationCommand) use ($handler) {
            $this->handlersCommand[$applicationCommand->id] = $handler;
        });
    }

    public function registerGlobalCommand(CommandBuilder $commandBuilder, Closure $handler): void
    {
        if (!isset($this->applicationId)) {
            $this->commandQueue[] = new QueuedCommand($commandBuilder, $handler);
            return;
        }

        $this->activateCommandListener();

        $this->discord->rest->globalCommand->createApplicationCommand(
            $this->applicationId,
            $commandBuilder
        )->then(function (ApplicationCommand $applicationCommand) use ($handler) {
            $this->handlersCommand[$applicationCommand->id] = $handler;
        });
    }

    private function activateCommandListener(): void
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

    private function handleCommandInteraction(InteractionCreate $interactionCreate): void
    {
        if (!isset($this->handlersCommand[$interactionCreate->data->id])) {
            return;
        }

        $firedCommand = new CommandInteraction($interactionCreate, $this->discord);

        $this->handlersCommand[$interactionCreate->data->id]($firedCommand);
    }

    public function onButtonInteraction(InteractionButton $interactionButton, callable $action): void
    {
        $this->activateButtonListener();

        $this->handlersButton[$interactionButton->customId] = $action;
    }

    private function activateButtonListener(): void
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

    private function handleButtonInteraction(InteractionCreate $interactionCreate): void
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
