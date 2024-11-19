<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Sticker;
use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\ModifyStickerBuilder;
use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class GuildSticker extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/sticker#list-guild-stickers
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Sticker[]>
     */
    public function list(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_STICKERS,
                    $guildId,
                )
            ),
            Sticker::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-guild-sticker
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Sticker>
     */
    public function get(string $guildId, string $stickerId): PromiseInterface
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
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-guild-sticker
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Sticker>
     */
    public function create(string $guildId, StickerBuilder $stickerBuilder): PromiseInterface
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
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#modify-guild-sticker
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Sticker>
     */
    public function modify(
        string $guildId,
        string $stickerId,
        ModifyStickerBuilder $modifyStickerBuilder
    ): PromiseInterface {
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
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#delete-guild-sticker
     *
     * @return PromiseInterface<void>
     */
    public function delete(string $guildId, string $stickerId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::GUILD_STICKER,
                $guildId,
                $stickerId
            )
        )->otherwise($this->logThrowable(...));
    }
}
