<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\User as PartsUser;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application
 */
class User extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/user#get-user
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function get(string $userId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::USER,
                    $userId,
                ),
            ),
            PartsUser::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function getCurrent(): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::USER_CURRENT,
            ),
            PartsUser::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#modify-current-user
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\User>
     */
    public function modifyCurrent(array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::USER_CURRENT,
                $params
            ),
            PartsUser::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-guilds
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     */
    public function getCurrentUserGuilds(
        ?string $before = null,
        ?string $after = null,
        ?int $limit = null,
        ?bool $withCounts = null
    ): ExtendedPromiseInterface {
        $endpoint = Endpoint::bind(Endpoint::USER_CURRENT_GUILD);

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
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#get-current-user-guild-member
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function getCurrentUserGuildMember(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::USER_CURRENT_MEMBER,
                    $guildId,
                ),
            ),
            GuildMember::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#leave-guild
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function leaveGuild(string $guildId): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::USER_CURRENT_GUILD,
                $guildId,
            ),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#create-dm
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function createDm(string $recipientId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::USER_CURRENT_CHANNELS,
                ['recipient_id' => $recipientId],
            ),
            Channel::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/user#create-dm
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function createGroupDm(array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::USER_CURRENT_CHANNELS,
                $params,
            ),
            Channel::class,
        )->otherwise($this->logThrowable(...));
    }
}
