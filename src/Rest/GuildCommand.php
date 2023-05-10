<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use Ragnarok\Fenrir\DataMapper;
use React\Promise\ExtendedPromiseInterface;

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
}
