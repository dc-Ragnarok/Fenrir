<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Fenrir\Parts\Sticker as PartsSticker;
use Exan\Fenrir\Parts\StickerPack;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/sticker
 */
class Sticker
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#get-sticker
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\Sticker>
     */
    public function get(string $stickerId)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::STICKER,
                    $stickerId
                )
            ),
            PartsSticker::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/sticker#list-nitro-sticker-packs
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\StickerPack[]>
     */
    public function listNitroPacks()
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::STICKER_PACKS,
                )
            ),
            StickerPack::class
        );
    }
}
