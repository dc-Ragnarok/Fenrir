<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\StickerPack;
use Ragnarok\Fenrir\Parts\Sticker as PartsSticker;
use Ragnarok\Fenrir\Rest\Sticker;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class StickerTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Sticker::class;

    public function httpBindingsProvider(): array
    {
        return [
            'Get sticker' => [
                'method' => 'get',
                'args' => ['::sticker id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsSticker::class,
                ]
            ],
            'List nitro packs' => [
                'method' => 'listNitroPacks',
                'args' => [],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => StickerPack::class,
                    'array' => true,
                ]
            ],
        ];
    }
}
