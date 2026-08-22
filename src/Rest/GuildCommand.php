<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject;
use Ragnarok\Fenrir\Parts\ApplicationCommandPermissionStructure;
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
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-guild-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function getApplicationCommand(
        string $applicationId,
        string $guildId,
        string $commandId
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMAND,
                    $applicationId,
                    $guildId,
                    $commandId,
                ),
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#edit-guild-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function editApplicationCommand(
        string $applicationId,
        string $guildId,
        string $commandId,
        CommandBuilder $commandBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMAND,
                    $applicationId,
                    $guildId,
                    $commandId,
                ),
                $commandBuilder->get(),
            ),
            ApplicationCommand::class
        );
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
        );
    }

    /**
     * Replaces the application's entire set of commands in the given guild in
     * one request.
     *
     * Commands that are not part of the given set are deleted, which makes this
     * the endpoint to reach for when registering the commands an application
     * declares rather than creating them one by one.
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#bulk-overwrite-guild-application-commands
     *
     * @param CommandBuilder[] $commandBuilders
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand[]>
     */
    public function bulkOverwriteApplicationCommands(
        string $applicationId,
        string $guildId,
        array $commandBuilders
    ): PromiseInterface {
        return $this->mapArrayPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMANDS,
                    $applicationId,
                    $guildId
                ),
                array_map(
                    static fn (CommandBuilder $commandBuilder) => $commandBuilder->get(),
                    array_values($commandBuilders)
                ),
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-application-command-permissions
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject>
     */
    public function getApplicationCommandPermissions(
        string $applicationId,
        string $guildId,
        string $commandId
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMAND_PERMISSIONS,
                    $applicationId,
                    $guildId,
                    $commandId,
                ),
            ),
            ApplicationCommandPermissionObject::class
        );
    }

    /**
     * Discord only accepts this call when authenticated with a bearer token
     * carrying the applications.commands.permissions.update scope; a bot token
     * is rejected.
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#edit-application-command-permissions
     *
     * @param ApplicationCommandPermissionStructure[] $permissions
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject>
     */
    public function editApplicationCommandPermissions(
        string $applicationId,
        string $guildId,
        string $commandId,
        array $permissions
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::GUILD_APPLICATION_COMMAND_PERMISSIONS,
                    $applicationId,
                    $guildId,
                    $commandId,
                ),
                ['permissions' => array_values($permissions)],
            ),
            ApplicationCommandPermissionObject::class
        );
    }
}
