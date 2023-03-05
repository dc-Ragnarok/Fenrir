<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Fenrir\Parts\Sticker;
use Exan\Fenrir\Rest\Helpers\GuildSticker\ModifyStickerBuilder;
use Exan\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class GuildSticker
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#list-guild-stickers
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker[]>
     */
    public function list(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_STICKERS,
                    $guildId,
                )
            ),
            Sticker::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-guild-sticker
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker>
     */
    public function get(string $guildId, string $stickerId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_STICKER,
                    $guildId,
                    $stickerId
                )
            ),
            Sticker::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-guild-sticker
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker>
     */
    public function create(string $guildId, StickerBuilder $stickerBuilder): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_STICKERS,
                    $guildId
                ),
                $stickerBuilder->get()
            ),
            Sticker::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#modify-guild-sticker
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker>
     */
    public function modify(
        string $guildId,
        string $stickerId,
        ModifyStickerBuilder $modifyStickerBuilder
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_STICKER,
                    $guildId,
                    $stickerId
                ),
                $modifyStickerBuilder->get()
            ),
            Sticker::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#delete-guild-sticker
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function delete(string $guildId, string $stickerId): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_STICKER,
                $guildId,
                $stickerId
            )
        );
    }
}
