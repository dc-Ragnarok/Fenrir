<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use Ragnarok\Fenrir\DataMapper;
use Psr\Http\Message\ResponseInterface;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\Promise;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands
 */
class GuildCommand extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#create-guild-application-command
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
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $applicationCommandId,
        string $guildId
    ): ExtendedPromiseInterface {
        return new Promise(
            function (callable $resolve, callable $reject) use ($applicationCommandId, $applicationId, $guildId) {
                $this->http->delete(
                    Endpoint::bind(
                        Endpoint::GUILD_APPLICATION_COMMAND,
                        $applicationId,
                        $guildId,
                        $applicationCommandId
                    )
                );
            }
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-guild-application-commands
     */
    public function getApplicationCommands(string $applicationId, string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMANDS,
                    $applicationId,
                    $guildId
                )
            ),
            ApplicationCommand::class
        );
    }
}
