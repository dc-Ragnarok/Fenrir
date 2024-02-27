<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Parts\ApplicationCommand;

class GlobalCommandExtension extends CommandExtension
{
    public function __construct(protected readonly string $applicationId)
    {
    }

    protected function loadExistingCommands(Discord $discord): void
    {
        $discord->rest->globalCommand->getCommands($this->applicationId)
            ->then(function (array $commands) {
                /** @var ApplicationCommand $command */
                foreach ($commands as $command) {
                    $this->commandMappings[$command->id] = $this->getFullNameByCommand($command);
                }
            });
    }
}
