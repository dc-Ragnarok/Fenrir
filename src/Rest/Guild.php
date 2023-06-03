<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild as PartsGuild;
use Ragnarok\Fenrir\Parts\GuildBan;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\GuildPreview;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyChannelPositionsBuilder;
use Ragnarok\Fenrir\Rest\HttpResource;
use React\Promise\ExtendedPromiseInterface;

class Guild extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/guild#create-guild
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     *
     * @todo Convert to builder
     */
    public function create(array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::GUILDS,
                $params
            ),
            PartsGuild::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     */
    public function get(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD,
                    $guildId
                )
            ),
            PartsGuild::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-preview
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildPreview>
     */
    public function getPreview(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_PREVIEW,
                    $guildId
                )
            ),
            GuildPreview::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     *
     * @todo Convert to builder
     */
    public function modify(string $guildId, array $params, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD,
                    $guildId
                ),
                $params,
                $this->getAuditLogReasonHeader($reason)
            ),
            PartsGuild::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#delete-guild
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function delete(string $guildId): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD,
                $guildId
            )
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-channels
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Channel[]>
     */
    public function getChannels(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_CHANNELS,
                    $guildId
                )
            ),
            Channel::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#create-guild-channel
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     *
     * @todo Convert to builder
     */
    public function createChannel(string $guildId, array $params, ?string $reason = null)
    {
        return $this->mapArrayPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_CHANNELS,
                    $guildId
                ),
                $params,
                $this->getAuditLogReasonHeader($reason)
            ),
            Channel::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @param ModifyChannelPositionsBuilder[] $modifyChannelPositionsBuilders
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function modifyChannelPositions(string $guildId, array $modifyChannelPositionsBuilders)
    {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_CHANNELS,
                $guildId,
            ),
            array_map(fn (ModifyChannelPositionsBuilder $builder) => $builder->get(), $modifyChannelPositionsBuilders)
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#list-active-guild-threads
     *
     * @todo This request isn't restful, wtf discord
     */
    public function listActiveThreads(string $guildId)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-member
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function getMember(string $guildId, string $memberId)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_MEMBER,
                    $guildId,
                    $memberId
                ),
            ),
            GuildMember::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#list-guild-members
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember[]>
     *
     * @todo Convert to builder
     */
    public function listMembers(string $guildId, array $queryParams): ExtendedPromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::GUILD_MEMBERS_SEARCH,
            $guildId,
        );

        foreach ($queryParams as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapArrayPromise(
            $this->http->get($endpoint),
            GuildMember::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#search-guild-members
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember[]>
     *
     * @todo Convert to builder
     */
    public function searchMembers(string $guildId, array $queryParams)
    {
        $endpoint = Endpoint::bind(
            Endpoint::GUILD_MEMBERS_SEARCH,
            $guildId,
        );

        foreach ($queryParams as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapArrayPromise(
            $this->http->get($endpoint),
            GuildMember::class
        )->otherwise($this->logThrowable(...));
    }

    public function addMember()
    {
    }

    public function modifyMember()
    {
    }

    public function modifyCurrentMember()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#add-guild-member-role
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function addMemberRole(string $guildId, string $userId, string $roleId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::GUILD_MEMBER_ROLE,
                $guildId,
                $userId,
                $roleId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#remove-guild-member-role
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function removeMemberRole(string $guildId, string $userId, string $roleId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_MEMBER_ROLE,
                $guildId,
                $userId,
                $roleId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    public function removeGuildMember()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-bans
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildBan>
     */
    public function getBans(string $guildId)
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_BANS,
                    $guildId,
                )
            ),
            GuildBan::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-ban
     */
    public function getBan(string $guildId, string $userId)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_BAN,
                    $guildId,
                    $userId
                )
            ),
            GuildBan::class
        )->otherwise($this->logThrowable(...));
    }

    public function createBan()
    {
    }

    public function removeBan()
    {
    }

    public function getRoles()
    {
    }

    public function createRole()
    {
    }

    public function modifyRolePositions()
    {
    }

    public function modifyRole()
    {
    }

    public function modifyMfaLevel()
    {
    }

    public function deleteRole()
    {
    }

    public function getPruneCount()
    {
    }

    public function beginPrune()
    {
    }

    public function getVoiceRegions()
    {
    }

    public function getInvites()
    {
    }

    public function getIntegrations()
    {
    }

    public function deleteIntegration()
    {
    }

    public function getWidgetSettings()
    {
    }

    public function modifyWidget()
    {
    }

    public function getWidget()
    {
    }

    public function getVanityUrl()
    {
    }

    public function getWidgetImage()
    {
    }

    public function getWelcomeScreen()
    {
    }

    public function modifyCurrentUserVoiceState()
    {
    }

    public function modifyUserVoiceState()
    {
    }
}
