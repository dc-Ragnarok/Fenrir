<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\Emoji as PartsEmoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\CreateEmojiBuilder;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/emoji
 */
class Emoji
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

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
        );
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
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#create-guild-emoji
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Emoji>
     */
    public function createGuildEmoji(
        string $guildId,
        CreateEmojiBuilder $emojiBuilder,
        string $reason = null
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
        );
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
        string $reason = null
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
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/emoji#delete-guild-emoji
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteGuildEmoji(
        string $guildId,
        string $emojiId,
        string $reason = null
    ): ExtendedPromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_EMOJI,
                $guildId,
                $emojiId
            ),
            null,
            $this->getAuditLogReasonHeader($reason)
        );
    }
}
