<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands
 */
class GuildCommand extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#create-guild-application-command
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function createApplicationCommand(
        string $applicationId,
        string $guildId,
        CommandBuilder $commandBuilder
    ): ExtendedPromiseInterface {
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
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#delete-guild-application-command
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $guildId,
        string $commandId
    ): ExtendedPromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_APPLICATION_COMMAND,
                $applicationId,
                $guildId,
                $commandId,
            ),
        )->otherwise($this->logThrowable(...));
    }
}
