<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Component\Button\InteractionButton;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Enums\InteractionType;
use Ragnarok\Fenrir\Extension\Extension;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Gateway\Events\Ready;
use Ragnarok\Fenrir\Interaction\ButtonInteraction;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;

class InteractionHandler implements Extension
{
    private readonly Discord $discord;

    private FilteredEventEmitter $commandListener;
    private FilteredEventEmitter $buttonListener;

    /** @var array<string, callable> */
    private array $handlersCommand = [];

    /** @var array<string, callable> */
    private array $handlersButton = [];

    private bool $devMode = false;

    /**
     * @param ?string $devGuildId
     *  When passed, reroute `$this->registerCommand` to be a Guild
     *  command rather than Global. Useful for testing without having to change
     *  this manually. Explicitly using `registerGlobalCommand` is not affected
     */
    public function __construct(private ?string $devGuildId = null)
    {
        if (!is_null($this->devGuildId)) {
            $this->devMode = true;
        }
    }

    public function initialize(Discord $discord): void
    {
        $this->discord = $discord;

        $this->commandListener = new FilteredEventEmitter(
            $this->discord->gateway->events,
            Events::INTERACTION_CREATE,
            fn (InteractionCreate $interactionCreate) =>
                isset($interactionCreate)
                && $interactionCreate?->type === InteractionType::APPLICATION_COMMAND
                && isset($this->handlersCommand[$interactionCreate->data->id])
        );

        $this->commandListener->on(Events::INTERACTION_CREATE, $this->handleCommandInteraction(...));
        $this->commandListener->start();

        $this->buttonListener = new FilteredEventEmitter(
            $this->discord->gateway->events,
            Events::INTERACTION_CREATE,
            fn (InteractionCreate $interactionCreate) =>
                isset($interactionCreate)
                && $interactionCreate?->type === InteractionType::MESSAGE_COMPONENT
                && $interactionCreate->data->component_type === 2 // @todo enum
                && isset($this->handlersButton[$interactionCreate->data->custom_id])
        );

        $this->buttonListener->on(Events::INTERACTION_CREATE, $this->handleButtonInteraction(...));
        $this->buttonListener->start();
    }

    private function handleCommandInteraction(InteractionCreate $interactionCreate): void
    {
        $firedCommand = new CommandInteraction($interactionCreate, $this->discord);

        $this->handlersCommand[$interactionCreate->data->id]($firedCommand);
    }

    private function handleButtonInteraction(InteractionCreate $interactionCreate): void
    {
        $buttonInteraction = new ButtonInteraction($interactionCreate, $this->discord);

        $remove = $this->handlersButton[$interactionCreate->data->custom_id]($buttonInteraction);

        if ($remove) {
            unset($this->handlersButton[$interactionCreate->data->custom_id]);
        }
    }

    public function registerCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        if ($this->devMode) {
            $this->registerGuildCommand($commandBuilder, $this->devGuildId, $handler);

            return;
        }

        $this->registerGlobalCommand($commandBuilder, $handler);
    }

    public function registerGuildCommand(CommandBuilder $commandBuilder, string $guildId, callable $handler): void
    {
        /** Ready event includes Application ID */
        $this->discord->gateway->events->once(
            Events::READY,
            function (Ready $ready) use ($guildId, $commandBuilder, $handler) {
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

    public function onButtonInteraction(InteractionButton $interactionButton, callable $action): void
    {
        $this->handlersButton[$interactionButton->customId] = $action;
    }
}
