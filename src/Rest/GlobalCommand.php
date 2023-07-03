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
class GlobalCommand extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-global-command
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationCommand>
     */
    public function createApplicationCommand(
        string $applicationId,
        CommandBuilder $commandBuilder
    ): ExtendedPromiseInterface {
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
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $commandId
    ): ExtendedPromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GLOBAL_APPLICATION_COMMAND,
                $applicationId,
                $commandId,
            ),
        )->otherwise($this->logThrowable(...));
    }
}
