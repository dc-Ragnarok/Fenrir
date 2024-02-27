<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Evenement\EventEmitter;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Extension\Extension;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure;

use function Freezemage\ArrayUtils\find;

class CommandExtension extends EventEmitter implements Extension
{
    private array $commandMappings = [];

    public function __construct(private readonly string $applicationId)
    {

    }

    public function initialize(Discord $discord): void
    {
        $discord->rest->globalCommand->getCommands($this->applicationId)
            ->then(function (array $commands) {
                /** @var ApplicationCommand $command */
                foreach ($commands as $command) {
                    $commandMappings[$command->id] = $this->getFullNameByCommand($command);
                }
            });
    }

    private function getFullNameByCommand(ApplicationCommand $command): string
    {
        $names = [$command->name];

        $subCommand = find($command->options ?? [], function (ApplicationCommandOptionStructure $option) {

        });

        return implode('.', $names);
    }
}
