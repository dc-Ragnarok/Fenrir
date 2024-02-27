<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Parts\ApplicationCommand;

class GuildCommandExtension extends CommandExtension
{
    public function __construct(protected readonly string $applicationId, protected readonly string $guildId)
    {
    }

    protected function loadExistingCommands(Discord $discord): void
    {
        $discord->rest->guildCommand->getCommands($this->guildId, $this->applicationId)
            ->then(function (array $commands) {
                /** @var ApplicationCommand $command */
                foreach ($commands as $command) {
                    $this->commandMappings[$command->id] = $this->getFullNameByCommand($command);
                }
            });
    }
}
