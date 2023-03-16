<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Command\FiredCommand;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use Exan\Fenrir\Websocket\Events\Ready;

class CommandHandler
{
    private bool $activated = false;

    /** @var array<string, callable> */
    private array $commands = [];

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
        $this->activateListener();

        /** Ready event includes Application ID */
        $this->discord->gateway->events->once(
            Events::READY,
            function (Ready $ready) use ($commandBuilder, $guildId, $handler) {
                $this->discord->rest->guildCommand->createApplicationCommand(
                    $ready->user->id,
                    $guildId,
                    $commandBuilder
                )->then(
                    fn (ApplicationCommand $applicationCommand) => $this->commands[$applicationCommand->id] = $handler
                );
            }
        );
    }

    public function registerGlobalCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        $this->activateListener();

        /** Ready event includes Application ID */
        $this->discord->gateway->events->once(Events::READY, function (Ready $ready) use ($commandBuilder, $handler) {
            $this->discord->rest->globalCommand->createApplicationCommand(
                $ready->user->id,
                $commandBuilder
            )->then(
                fn (ApplicationCommand $applicationCommand) => $this->commands[$applicationCommand->id] = $handler
            );
        });
    }

    private function activateListener()
    {
        if ($this->activated) {
            return;
        }

        $this->activated = true;

        $this->discord->gateway->events->on(
            Events::INTERACTION_CREATE,
            $this->handleInteraction(...)
        );
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
