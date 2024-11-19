<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands
 */
class GuildCommand extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-guild-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand[]>
     */
    public function getCommands(string $guildId, string $applicationId, bool $withLocalizations = false): PromiseInterface
    {
        $endpoint = Endpoint::bind(Endpoint::GUILD_APPLICATION_COMMANDS, $applicationId, $guildId);
        $endpoint->addQuery('with_localizations', $withLocalizations);

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#create-guild-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function createApplicationCommand(
        string $applicationId,
        string $guildId,
        CommandBuilder $commandBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMANDS,
                    $applicationId,
                    $guildId
                ),
                $commandBuilder->get(),
            ),
            ApplicationCommand::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#delete-guild-application-command
     *
     * @return PromiseInterface<void>
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $guildId,
        string $commandId
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_APPLICATION_COMMAND,
                $applicationId,
                $guildId,
                $commandId,
            ),
        )->catch($this->logThrowable(...));
    }
}
