<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\GuildSoundboardSounds;
use Ragnarok\Fenrir\Parts\SoundboardSound;
use Ragnarok\Fenrir\Rest\Helpers\Soundboard\CreateSoundboardSoundBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Soundboard\ModifySoundboardSoundBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/soundboard
 */
class Soundboard extends HttpResource
{
    /**
     * Plays a soundboard sound in the voice channel the current user is
     * connected to. Fires a voice channel effect send event.
     *
     * @see https://discord.com/developers/docs/resources/soundboard#send-soundboard-sound
     *
     * @return PromiseInterface<void>
     */
    public function sendSoundboardSound(
        string $channelId,
        string $soundId,
        ?string $sourceGuildId = null
    ): PromiseInterface {
        $params = ['sound_id' => $soundId];

        if (!is_null($sourceGuildId)) {
            $params['source_guild_id'] = $sourceGuildId;
        }

        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_SEND_SOUNDBOARD_SOUND,
                $channelId
            ),
            $params
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/soundboard#list-default-soundboard-sounds
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\SoundboardSound[]>
     */
    public function listDefaultSounds(): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(Endpoint::SOUNDBOARD_DEFAULT_SOUNDS)
            ),
            SoundboardSound::class
        );
    }

    /**
     * Unlike the default sounds, Discord wraps a guild's sounds in an object
     * with an "items" array rather than returning them bare.
     *
     * @see https://discord.com/developers/docs/resources/soundboard#list-guild-soundboard-sounds
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildSoundboardSounds>
     */
    public function listGuildSounds(string $guildId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_SOUNDBOARD_SOUNDS,
                    $guildId
                )
            ),
            GuildSoundboardSounds::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/soundboard#get-guild-soundboard-sound
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\SoundboardSound>
     */
    public function getGuildSound(string $guildId, string $soundId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_SOUNDBOARD_SOUND,
                    $guildId,
                    $soundId
                )
            ),
            SoundboardSound::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/soundboard#create-guild-soundboard-sound
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\SoundboardSound>
     */
    public function createGuildSound(
        string $guildId,
        CreateSoundboardSoundBuilder $soundBuilder,
        ?string $reason = null
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_SOUNDBOARD_SOUNDS,
                    $guildId
                ),
                $soundBuilder->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            SoundboardSound::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/soundboard#modify-guild-soundboard-sound
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\SoundboardSound>
     */
    public function modifyGuildSound(
        string $guildId,
        string $soundId,
        ModifySoundboardSoundBuilder $soundBuilder,
        ?string $reason = null
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_SOUNDBOARD_SOUND,
                    $guildId,
                    $soundId
                ),
                $soundBuilder->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            SoundboardSound::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/soundboard#delete-guild-soundboard-sound
     *
     * @return PromiseInterface<void>
     */
    public function deleteGuildSound(
        string $guildId,
        string $soundId,
        ?string $reason = null
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_SOUNDBOARD_SOUND,
                $guildId,
                $soundId
            ),
            null,
            $this->getAuditLogReasonHeader($reason)
        );
    }
}
