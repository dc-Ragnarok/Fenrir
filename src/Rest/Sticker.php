<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Fenrir\Parts\Sticker as PartsSticker;
use Exan\Fenrir\Parts\StickerPack;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use Exan\Fenrir\DataMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class Sticker extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-sticker
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker>
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
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\StickerPack[]>
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
