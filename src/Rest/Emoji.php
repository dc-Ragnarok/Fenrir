<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Emoji as PartsEmoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\CreateEmojiBuilder;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/emoji
 */
class Emoji extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/emoji#list-guild-emojis
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji[]>
     */
    public function listGuildEmojis(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_EMOJIS,
                    $guildId
                )
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#get-guild-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function getGuildEmoji(string $guildId, string $emojiId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_EMOJI,
                    $guildId,
                    $emojiId
                )
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#create-guild-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function createGuildEmoji(
        string $guildId,
        CreateEmojiBuilder $emojiBuilder,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_EMOJIS,
                    $guildId
                ),
                $emojiBuilder->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#modify-guild-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function modifyGuildEmoji(
        string $guildId,
        string $emojiId,
        CreateEmojiBuilder $emojiBuilder,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_EMOJI,
                    $guildId,
                    $emojiId
                ),
                $emojiBuilder->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#delete-guild-emoji
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteGuildEmoji(
        string $guildId,
        string $emojiId,
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_EMOJI,
                $guildId,
                $emojiId
            ),
            null,
            $this->getAuditLogReasonHeader($reason)
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#list-application-emojis
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji[]>
     */
    public function listApplicationEmojis(string $applicationId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    'applications/:application/emojis',
                    $applicationId
                ),
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#get-application-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function getApplicationEmoji(string $guildId, string $emojiId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    'applications/:application/emojis/:emoji',
                    $guildId,
                    $emojiId
                )
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#create-application-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function createApplicationEmoji(
        string $applicationId,
        CreateEmojiBuilder $emojiBuilder,
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    'applications/:application/emojis',
                    $applicationId
                ),
                $emojiBuilder->get(),
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#modify-application-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function modifyApplicationEmoji(
        string $applicationId,
        string $emojiId,
        CreateEmojiBuilder $emojiBuilder,
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    'applications/:application/emojis/:emoji',
                    $applicationId,
                    $emojiId
                ),
                $emojiBuilder->get(),
            ),
            PartsEmoji::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#delete-application-emoji
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteApplicationEmoji(
        string $applicationId,
        string $emojiId,
    ): ExtendedPromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                'applications/:application/emojis/:emoji',
                $applicationId,
                $emojiId
            ),
        )->otherwise($this->logThrowable(...));
    }
}
