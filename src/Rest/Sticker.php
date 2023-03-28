<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\Sticker as PartsSticker;
use Ragnarok\Fenrir\Parts\StickerPack;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use Ragnarok\Fenrir\DataMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class Sticker extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-sticker
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Sticker>
     */
    public function get(string $stickerId): ExtendedPromiseInterface
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
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\StickerPack[]>
     */
    public function listNitroPacks(): ExtendedPromiseInterface
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
