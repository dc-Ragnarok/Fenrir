<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\ApplicationRoleConnection;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Connection;
use Ragnarok\Fenrir\Parts\Guild;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\User as PartsUser;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application
 */
class User extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/user#get-user
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function get(string $userId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::USER,
                    $userId,
                ),
            ),
            PartsUser::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function getCurrent(): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::USER_CURRENT,
            ),
            PartsUser::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#modify-current-user
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function modifyCurrent(array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::USER_CURRENT,
                $params
            ),
            PartsUser::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-guilds
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Guild[]>
     */
    public function getCurrentUserGuilds(
        ?string $before = null,
        ?string $after = null,
        ?int $limit = null,
        ?bool $withCounts = null
    ): PromiseInterface {
        $endpoint = Endpoint::bind(Endpoint::USER_CURRENT_GUILDS);

        if ($before) {
            $endpoint->addQuery('before', $before);
        }

        if ($after) {
            $endpoint->addQuery('after', $after);
        }

        if ($limit) {
            $endpoint->addQuery('limit', $limit);
        }

        if ($withCounts) {
            $endpoint->addQuery('with_counts', $withCounts);
        }

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint,
            ),
            Guild::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-guild-member
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function getCurrentUserGuildMember(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::USER_CURRENT_MEMBER,
                    $guildId,
                ),
            ),
            GuildMember::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#leave-guild
     *
     * @return PromiseInterface<void>
     */
    public function leaveGuild(string $guildId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::USER_CURRENT_GUILD,
                $guildId,
            ),
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#create-dm
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function createDm(string $recipientId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::USER_CURRENT_CHANNELS,
                ['recipient_id' => $recipientId],
            ),
            Channel::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#create-dm
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function createGroupDm(array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::USER_CURRENT_CHANNELS,
                $params,
            ),
            Channel::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-connections
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Connection>
     */
    public function getCurrentUserConnections(): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::USER_CURRENT_CONNECTIONS,
            ),
            Connection::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-application-role-connection
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnection>
     */
    public function getCurrentUserApplicationRoleConnection(string $applicationId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::USER_CURRENT_APPLICATION_ROLE_CONNECTION,
                    $applicationId
                ),
            ),
            ApplicationRoleConnection::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#update-current-user-application-role-connection
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnection>
     */
    public function updateCurrentUserApplicationRoleConnection(string $applicationId, array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::USER_CURRENT_APPLICATION_ROLE_CONNECTION,
                    $applicationId
                ),
                $params
            ),
            ApplicationRoleConnection::class,
        );
    }
}
