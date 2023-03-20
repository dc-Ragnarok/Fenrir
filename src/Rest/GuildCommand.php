<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use Exan\Fenrir\DataMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/interactions/application-commands
 */
class GuildCommand
{
    use HttpHelper;

    public function __construct(private Http $http, private DataMapper $dataMapper)
    {
    }

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
        );
    }
}
