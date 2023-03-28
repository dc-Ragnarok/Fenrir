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
class GlobalCommand extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-global-command
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
     * @see https://discord.com/developers/docs/interactions/application-commands#making-a-global-command
     */
    public function deleteApplicationCommand(
        string $applicationId,
        string $applicationCommandId
    ): ExtendedPromiseInterface {
        return new Promise(function (callable $resolve, callable $reject) use ($applicationCommandId, $applicationId) {
            $this->http->delete(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMAND,
                    $applicationId,
                    $applicationCommandId
                )
            );
        });
    }

    /**
     * @see https://discord.com/developers/docs/interactions/application-commands#get-global-application-commands
     */
    public function getApplicationCommands(string $applicationId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GLOBAL_APPLICATION_COMMANDS,
                    $applicationId
                )
            ),
            ApplicationCommand::class
        );
    }
}
