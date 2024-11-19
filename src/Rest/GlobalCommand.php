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
        )->otherwise($this->logThrowable(...));
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
        )->otherwise($this->logThrowable(...));
    }
}
