<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Closure;
use Exan\Fenrir\Component\Button\InteractionButton;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\Enums\Parts\InteractionTypes;
use Exan\Fenrir\Interaction\ButtonInteraction;
use Exan\Fenrir\Interaction\CommandInteraction;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Rest\Helpers\Command\QueuedCommand;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use Exan\Fenrir\Websocket\Events\Ready;
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

                $compareCommands = function (array $commands, bool $checkGlobalCommands) {
                    try {
                    /** @var ApplicationCommand[] $commands */
                    foreach ($this->commandQueue as $key => $queuedCommand) {
                        echo $checkGlobalCommands ? "Checking global commands\n" : "Checking Guild {$queuedCommand->guildId} Commands\n";

                        if (!$queuedCommand->isGlobalCommand() && $checkGlobalCommands) {
                            echo $queuedCommand->commandBuilder->getName().PHP_EOL;
                            continue;
                        }

                        $needsRegistered = true;

                        foreach ($commands as $key => $command) {
                            if ($command->guild_id ?? null !== $queuedCommand->guildId) {
                                continue;
                            }

                            if ($queuedCommand->commandBuilder->getName() === $command->name) {
                                $needsRegistered = !$queuedCommand->commandBuilder->matchesApplicationCommand($command);

                                unset($commands[$key]);
                                unset($this->commandQueue[$key]);
                                break;
                            }
                        }

                        if (!$needsRegistered) {
                            echo "{$queuedCommand->commandBuilder->getName()} does not need registered\n";

                            $this->handlersCommand[$command->id] = $queuedCommand->handler;
                        } else {
                            echo "{$queuedCommand->commandBuilder->getName()} does need registered\n";

                            if ($queuedCommand->guildId === null) {
                                $this->registerGlobalCommand($queuedCommand->commandBuilder, $queuedCommand->handler);
                            } else {
                                $this->registerGuildCommand($queuedCommand->commandBuilder, $queuedCommand->guildId, $queuedCommand->handler);
                            }
                        }
                    }
                    } catch (Throwable $e) {
                        echo $e;
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
        } else {
            $this->registerGlobalCommand($commandBuilder, $handler);
        }
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
