<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild as PartsGuild;
use Ragnarok\Fenrir\Parts\GuildPreview;
use Ragnarok\Fenrir\Rest\HttpResource;
use React\Promise\ExtendedPromiseInterface;

class Guild extends HttpResource
{
    public function create()
    {

    }

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

    public function modify()
    {

    }

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

    public function createChannel()
    {

    }

    public function modifyChannelPositions()
    {

    }

    public function listActiveThreads()
    {

    }

    public function getMember()
    {

    }

    public function listMembers()
    {

    }

    public function searchMembers()
    {

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

    public function addMemberRole()
    {

    }

    public function removeGuildMember()
    {

    }

    public function getBans()
    {

    }

    public function getBan()
    {

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
