<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\Emoji as PartsEmoji;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use Exan\Dhp\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

class Emoji
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

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

    public function createGuildEmoji(string $guildId, EmojiBuilder $emojiBuilder, string $reason = null): ExtendedPromiseInterface
    {
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

    public function modifyGuildEmoji(string $guildId, string $emojiId, EmojiBuilder $emojiBuilder, string $reason = null): ExtendedPromiseInterface
    {
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

    public function deleteGuildEmoji(string $guildId, string $emojiId): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_EMOJI,
                $guildId,
                $emojiId
            ),
        );
    }
}
