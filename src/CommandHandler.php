<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Command\FiredCommand;
use Exan\Fenrir\Const\Events;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;

class CommandHandler
{
    private bool $activated = false;

    private array $commands = [];

    public function __construct(private Discord $discord, private string $applicationId)
    {
        
    }

    public function registerCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        if ($this->discord->dev) {
            $this->registerGuildCommand($commandBuilder, $this->discord->devGuild, $handler);
        }
    }

    public function registerGuildCommand(CommandBuilder $commandBuilder, string $guildId, callable $handler): void
    {
        $this->activate();

        $this->discord->rest->guildCommand->createApplicationCommand(
            $this->applicationId,
            $guildId,
            $commandBuilder
        )->then(
            fn (ApplicationCommand $applicationCommand) => $this->commands[$applicationCommand->id] = $handler
        );
    }

    public function registerGlobalCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        $this->activate();
    }

    private function activate()
    {
        if ($this->activated) {
            return;
        }

        $this->discord->events->on(Events::INTERACTION_CREATE, $this->handleInteraction(...));
    }

    private function handleInteraction(InteractionCreate $interactionCreate)
    {
        if (!isset($this->commands[$interactionCreate->data->id])) {
            return;
        }

        $firedCommand = new FiredCommand($interactionCreate, $this->discord);

        $this->commands[$interactionCreate->data->id]($firedCommand);
    }
}
