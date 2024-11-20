<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\GuildScheduledEvent as PartsGuildScheduledEvent;
use Ragnarok\Fenrir\Parts\GuildScheduledEventUser;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/guild-scheduled-event
 */
class GuildScheduledEvent extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#list-scheduled-events-for-guild
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildScheduledEvent[]>
     */
    public function list(string $guildId, bool $withUserCount = false): PromiseInterface
    {
        $endpoint = Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENTS, $guildId);
        $endpoint->addQuery('with_user_count', $withUserCount);

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint
            ),
            PartsGuildScheduledEvent::class,
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#get-guild-scheduled-event
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildScheduledEvent>
     */
    public function get(string $guildId, string $scheduledEventId, bool $withUserCount = false): PromiseInterface
    {
        $endpoint = Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENT, $guildId, $scheduledEventId);
        $endpoint->addQuery('with_user_count', $withUserCount);

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint
            ),
            PartsGuildScheduledEvent::class,
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#create-guild-scheduled-event
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildScheduledEvent>
     */
    public function create(string $guildId, array $params, ?string $reason = null): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->post(
                Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENTS, $guildId),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsGuildScheduledEvent::class,
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#modify-guild-scheduled-event
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildScheduledEvent>
     */
    public function modify(string $guildId, string $scheduledEventId, array $params, ?string $reason = null): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->patch(
                Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENT, $guildId, $scheduledEventId),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsGuildScheduledEvent::class,
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#delete-guild-scheduled-event
     * @return PromiseInterface<void>
     */
    public function delete(string $guildId, string $scheduledEventId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENT, $guildId, $scheduledEventId),
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#get-guild-scheduled-event-users
     */
    public function getUsers(
        string $guildId,
        string $scheduledEventId,
        int $limit = 100,
        bool $withMembers = false,
        ?string $before = null,
        ?string $after = null,
    ): PromiseInterface {
        $endpoint = Endpoint::bind(Endpoint::GUILD_SCHEDULED_EVENT_USERS, $guildId, $scheduledEventId);

        $endpoint->addQuery('limit', $limit);
        $endpoint->addQuery('with_members', $withMembers);

        if (!is_null($before)) {
            $endpoint->addQuery('before', $before);
        }

        if (!is_null($after)) {
            $endpoint->addQuery('after', $after);
        }

        return $this->mapArrayPromise(
            $this->http->get(
                $endpoint
            ),
            GuildScheduledEventUser::class,
        )->catch($this->logThrowable(...));
    }
}
