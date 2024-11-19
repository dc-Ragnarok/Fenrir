<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Sticker as PartsSticker;
use Ragnarok\Fenrir\Parts\StickerPack;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class Sticker extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-sticker
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Sticker>
     */
    public function get(string $stickerId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::STICKER,
                    $stickerId
                )
            ),
            PartsSticker::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#list-nitro-sticker-packs
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\StickerPack[]>
     */
    public function listNitroPacks(): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::STICKER_PACKS,
                )
            ),
            StickerPack::class
        )->otherwise($this->logThrowable(...));
    }
}
