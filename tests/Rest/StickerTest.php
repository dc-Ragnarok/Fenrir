<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest;

use Exan\Fenrir\Parts\StickerPack;
use Exan\Fenrir\Parts\Sticker as PartsSticker;
use Exan\Fenrir\Rest\Sticker;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class StickerTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new Sticker($this->http, $this->jsonMapper);
    }

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
