<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Emoji as PartsEmoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\CreateEmojiBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/emoji
 */
class Emoji extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/emoji#list-guild-emojis
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji[]>
     */
    public function listGuildEmojis(string $guildId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function getGuildEmoji(string $guildId, string $emojiId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function createGuildEmoji(
        string $guildId,
        CreateEmojiBuilder $emojiBuilder,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function modifyGuildEmoji(
        string $guildId,
        string $emojiId,
        CreateEmojiBuilder $emojiBuilder,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function deleteGuildEmoji(
        string $guildId,
        string $emojiId,
        ?string $reason = null
    ): PromiseInterface {
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji[]>
     */
    public function listApplicationEmojis(string $applicationId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function getApplicationEmoji(string $guildId, string $emojiId): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function createApplicationEmoji(
        string $applicationId,
        CreateEmojiBuilder $emojiBuilder,
    ): PromiseInterface {
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function modifyApplicationEmoji(
        string $applicationId,
        string $emojiId,
        CreateEmojiBuilder $emojiBuilder,
    ): PromiseInterface {
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
     * @return PromiseInterface<void>
     */
    public function deleteApplicationEmoji(
        string $applicationId,
        string $emojiId,
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                'applications/:application/emojis/:emoji',
                $applicationId,
                $emojiId
            ),
        )->otherwise($this->logThrowable(...));
    }
}
