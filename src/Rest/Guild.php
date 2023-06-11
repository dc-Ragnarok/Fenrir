<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Enums\Parts\MfaLevels;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild as PartsGuild;
use Ragnarok\Fenrir\Parts\GuildBan;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\GuildPreview;
use Ragnarok\Fenrir\Parts\Integration;
use Ragnarok\Fenrir\Parts\Invite;
use Ragnarok\Fenrir\Parts\PruneCount;
use Ragnarok\Fenrir\Parts\Role;
use Ragnarok\Fenrir\Parts\VoiceRegion;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyChannelPositionsBuilder;
use Ragnarok\Fenrir\Rest\HttpResource;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/guild
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
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
    public function createChannel(string $guildId, array $params, ?string $reason = null): ExtendedPromiseInterface
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
    public function modifyChannelPositions(
        string $guildId,
        array $modifyChannelPositionsBuilders
    ): ExtendedPromiseInterface {
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
    public function listActiveThreads(string $guildId): void
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-member
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function getMember(string $guildId, string $memberId): ExtendedPromiseInterface
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
    public function searchMembers(string $guildId, array $queryParams): ExtendedPromiseInterface
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
     * @see https://discord.com/developers/docs/resources/guild#add-guild-member
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     *
     * @todo Convert to builder
     */
    public function addMember(string $guildId, string $userId, array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::GUILD_MEMBER,
                    $guildId,
                    $userId,
                ),
                $params,
            ),
            GuildMember::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild-member
     *
     * @return ExtendedPromiseInterface<void>
     *
     * @todo Convert to builder
     */
    public function modifyMember(
        string $guildId,
        string $userId,
        array $params,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_MEMBER,
                $guildId,
                $userId,
            ),
            $params,
            $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-current-member
     *
     * @return ExtendedPromiseInterface<void>
     *
     * @todo Convert to builder
     */
    public function modifyCurrentMember(
        string $guildId,
        array $params,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_MEMBER_SELF,
                $guildId,
            ),
            $params,
            $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#add-guild-member-role
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function addMemberRole(
        string $guildId,
        string $userId,
        string $roleId,
        ?string $reason = null
    ): ExtendedPromiseInterface {
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
    public function removeMemberRole(
        string $guildId,
        string $userId,
        string $roleId,
        ?string $reason = null
    ): ExtendedPromiseInterface {
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

    /**
     * @see https://discord.com/developers/docs/resources/guild#remove-guild-member
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function removeGuildMember(string $guildId, string $userId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_MEMBER,
                $guildId,
                $userId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-bans
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildBan[]>
     */
    public function getBans(string $guildId): ExtendedPromiseInterface
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
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildBan[]>
     */
    public function getBan(string $guildId, string $userId): ExtendedPromiseInterface
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

    /**
     * @see https://discord.com/developers/docs/resources/guild#create-guild-ban
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function createBan(
        string $guildId,
        string $userId,
        array $params,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::GUILD_BAN,
                $guildId,
                $userId,
            ),
            $params,
            $this->getAuditLogReasonHeader($reason)
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#remove-guild-ban
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function removeBan(string $guildId, string $userId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_BAN,
                $guildId,
                $userId,
            ),
            headers: $this->getAuditLogReasonHeader($reason)
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-roles
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Role[]>
     */
    public function getRoles(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_ROLES,
                    $guildId
                )
            ),
            Role::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#create-guild-role
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Role>
     */
    public function createRole(string $guildId, array $params, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_ROLES,
                    $guildId
                ),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            Role::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild-role-positions
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Role[]>
     */
    public function modifyRolePositions(
        string $guildId,
        array $params,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->mapArrayPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_ROLES,
                    $guildId,
                ),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            Role::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild-role
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Role>
     */
    public function modifyRole(
        string $guildId,
        string $roleId,
        array $params,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_ROLE,
                    $guildId,
                    $roleId
                ),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            Role::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild-mfa-level
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function modifyMfaLevel(
        string $guildId,
        MfaLevels $mfaLevel,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::GUILD_MFA,
                $guildId,
            ),
            ['level' => $mfaLevel->value],
            $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#delete-guild-role
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteRole(string $guildId, string $roleId, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_ROLE,
                $guildId,
                $roleId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-prune-count
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\PruneCount>
     */
    public function getPruneCount(string $guildId, array $queryParams): ExtendedPromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::GUILD_PRUNE,
            $guildId,
        );

        foreach ($queryParams as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapPromise(
            $this->http->get(
                $endpoint,
            ),
            PruneCount::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#begin-guild-prune
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\PruneCount>
     */
    public function beginPrune(string $guildId, array $params, ?string $reason = null): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_PRUNE,
                    $guildId,
                ),
                $params,
                headers: $this->getAuditLogReasonHeader($reason)
            ),
            PruneCount::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-voice-regions
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\VoiceRegion>
     */
    public function getVoiceRegions(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_REGIONS,
                    $guildId,
                ),
            ),
            VoiceRegion::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-invites
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function getInvites(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_REGIONS,
                    $guildId,
                ),
            ),
            Invite::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-integrations
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Integration>
     */
    public function getIntegrations(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_INTEGRATIONS,
                    $guildId,
                ),
            ),
            Integration::class
        );
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
