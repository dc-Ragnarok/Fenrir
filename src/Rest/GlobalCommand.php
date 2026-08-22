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
class GlobalCommand extends HttpResource
{
    public function getCommands(string $applicationId, bool $withLocalizations = false): PromiseInterface
    {
        $endpoint = Endpoint::bind(Endpoint::GLOBAL_APPLICATION_COMMANDS, $applicationId);
        $endpoint->addQuery('with_localizations', $withLocalizations);

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-global-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function createApplicationCommand(
        string $applicationId,
        CommandBuilder $commandBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMANDS,
                    $applicationId
                ),
                $commandBuilder->get(),
            ),
            ApplicationCommand::class
        );
    }


    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-global-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function getApplicationCommand(
        string $applicationId,
        string $commandId
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMAND,
                    $applicationId,
                    $commandId,
                ),
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#edit-global-application-command
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function editApplicationCommand(
        string $applicationId,
        string $commandId,
        CommandBuilder $commandBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMAND,
                    $applicationId,
                    $commandId,
                ),
                $commandBuilder->get(),
            ),
            ApplicationCommand::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#delete-global-application-command
     *
     * @return PromiseInterface<void>
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $commandId
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GLOBAL_APPLICATION_COMMAND,
                $applicationId,
                $commandId,
            ),
        );
    }

    /**
     * Replaces the application's entire set of global commands in one request.
     *
     * Commands that are not part of the given set are deleted, which makes this
     * the endpoint to reach for when registering the commands an application
     * declares rather than creating them one by one.
     *
     * @see https://discord.com/developers/docs/interactions/application-commands#bulk-overwrite-global-application-commands
     *
     * @param CommandBuilder[] $commandBuilders
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand[]>
     */
    public function bulkOverwriteApplicationCommands(
        string $applicationId,
        array $commandBuilders
    ): PromiseInterface {
        return $this->mapArrayPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMANDS,
                    $applicationId
                ),
                array_map(
                    static fn (CommandBuilder $commandBuilder) => $commandBuilder->get(),
                    array_values($commandBuilders)
                ),
            ),
            ApplicationCommand::class
        );
    }
}
