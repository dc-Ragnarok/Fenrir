<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Enums\MfaLevel;
use Ragnarok\Fenrir\Parts\ActiveGuildThreads;
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
use Ragnarok\Fenrir\Parts\WelcomeScreen;
use Ragnarok\Fenrir\Parts\Widget;
use Ragnarok\Fenrir\Parts\WidgetSettings;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyChannelPositionsBuilder;
use React\Promise\PromiseInterface;

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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     *
     * @todo Convert to builder
     */
    public function create(array $params): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     */
    public function get(string $guildId, bool $withCounts = false): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::GUILD,
            $guildId
        );

        if ($withCounts) {
            $endpoint->addQuery('with_counts', true);
        }

        return $this->mapPromise(
            $this->http->get(
                $endpoint,
            ),
            PartsGuild::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-preview
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildPreview>
     */
    public function getPreview(string $guildId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     *
     * @todo Convert to builder
     */
    public function modify(string $guildId, array $params, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<void>
     */
    public function delete(string $guildId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel[]>
     */
    public function getChannels(string $guildId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     *
     * @todo Convert to builder
     */
    public function createChannel(string $guildId, array $params, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<void>
     */
    public function modifyChannelPositions(
        string $guildId,
        array $modifyChannelPositionsBuilders
    ): PromiseInterface {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_CHANNELS,
                $guildId,
            ),
            array_map(fn(ModifyChannelPositionsBuilder $builder) => $builder->get(), $modifyChannelPositionsBuilders)
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#list-active-guild-threads
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ActiveGuildThreads>
     */
    public function listActiveThreads(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_THREADS_ACTIVE,
                    $guildId,
                )
            ),
            ActiveGuildThreads::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-member
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function getMember(string $guildId, string $memberId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember[]>
     *
     * @todo Convert to builder
     */
    public function listMembers(string $guildId, array $queryParams): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember[]>
     */
    public function searchMembers(string $guildId, array $queryParams): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildMember>
     */
    public function addMember(string $guildId, string $userId, array $params): PromiseInterface
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
     * @return PromiseInterface<void>
     */
    public function modifyMember(
        string $guildId,
        string $userId,
        array $params,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function modifyCurrentMember(
        string $guildId,
        array $params,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function addMemberRole(
        string $guildId,
        string $userId,
        string $roleId,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function removeMemberRole(
        string $guildId,
        string $userId,
        string $roleId,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function removeGuildMember(string $guildId, string $userId, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildBan[]>
     */
    public function getBans(string $guildId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildBan[]>
     */
    public function getBan(string $guildId, string $userId): PromiseInterface
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
     * @return PromiseInterface<void>
     */
    public function createBan(
        string $guildId,
        string $userId,
        array $params,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function removeBan(string $guildId, string $userId, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Role[]>
     */
    public function getRoles(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_ROLES,
                    $guildId
                )
            ),
            Role::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#create-guild-role
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Role>
     */
    public function createRole(string $guildId, array $params, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Role[]>
     */
    public function modifyRolePositions(
        string $guildId,
        array $params,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Role>
     */
    public function modifyRole(
        string $guildId,
        string $roleId,
        array $params,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function modifyMfaLevel(
        string $guildId,
        MfaLevel $mfaLevel,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function deleteRole(string $guildId, string $roleId, ?string $reason = null): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_ROLE,
                $guildId,
                $roleId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-prune-count
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\PruneCount>
     */
    public function getPruneCount(string $guildId, array $queryParams): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\PruneCount>
     */
    public function beginPrune(string $guildId, array $params, ?string $reason = null): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\VoiceRegion>
     */
    public function getVoiceRegions(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_REGIONS,
                    $guildId,
                ),
            ),
            VoiceRegion::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-invites
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function getInvites(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_REGIONS,
                    $guildId,
                ),
            ),
            Invite::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-integrations
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Integration>
     */
    public function getIntegrations(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_INTEGRATIONS,
                    $guildId,
                ),
            ),
            Integration::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#delete-guild-integration
     *
     * @return PromiseInterface<void>
     */
    public function deleteIntegration(
        string $guildId,
        string $integrationId,
        ?string $reason = null
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_INTEGRATION,
                $guildId,
                $integrationId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-widget-settings
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\WidgetSettings>
     */
    public function getWidgetSettings(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_WIDGET_SETTINGS,
                    $guildId,
                ),
            ),
            WidgetSettings::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-guild-widget
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\WidgetSettings>
     */
    public function modifyWidget(string $guildId, array $params, ?string $reason = null): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_WIDGET_SETTINGS,
                    $guildId,
                ),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            WidgetSettings::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-widget
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Widget>
     */
    public function getWidget(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_WIDGET,
                    $guildId,
                )
            ),
            Widget::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-vanity-url
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function getVanityUrl(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_VANITY_URL,
                    $guildId,
                )
            ),
            Invite::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-widget-image
     *
     * @return string The url of the guild widget image
     */
    public function getWidgetImage(string $guildId, array $queryParams): string
    {
        $endpoint = Endpoint::bind(
            Endpoint::GUILD_WIDGET_IMAGE,
            $guildId,
        );

        foreach ($queryParams as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return (string) $endpoint;
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#get-guild-welcome-screen
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\WelcomeScreen>
     */
    public function getWelcomeScreen(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_WELCOME_SCREEN,
                    $guildId,
                ),
            ),
            WelcomeScreen::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-current-user-voice-state
     *
     * @return PromiseInterface<void>
     */
    public function modifyCurrentUserVoiceState(string $guildId, array $params): PromiseInterface
    {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_USER_CURRENT_VOICE_STATE,
                $guildId,
            ),
            $params,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild#modify-user-voice-state
     *
     * @return PromiseInterface<void>
     */
    public function modifyUserVoiceState(string $guildId, string $userId, array $params): PromiseInterface
    {
        return $this->http->patch(
            Endpoint::bind(
                Endpoint::GUILD_USER_CURRENT_VOICE_STATE,
                $guildId,
                $userId
            ),
            $params,
        )->otherwise($this->logThrowable(...));
    }
}
