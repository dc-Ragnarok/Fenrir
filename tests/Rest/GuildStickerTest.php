<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest;

use Exan\Fenrir\Parts\StickerPack;
use Exan\Fenrir\Parts\Sticker;
use Exan\Fenrir\Rest\GuildSticker;
use Exan\Fenrir\Rest\Helpers\GuildSticker\ModifyStickerBuilder;
use Exan\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class GuildStickerTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new GuildSticker($this->http, $this->jsonMapper);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'List stickers' => [
                'method' => 'list',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => Sticker::class,
                    'array' => true,
                ]
            ],
            'Get sticker' => [
                'method' => 'get',
                'args' => ['::guild id::', '::sticker id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Sticker::class,
                    'array' => true,
                ]
            ],
            'Create sticker' => [
                'method' => 'create',
                'args' => [
                    '::guild id::',
                    (new StickerBuilder())->setFile('spooky binary data', 'png')
                ],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Sticker::class,
                    'array' => true,
                ]
            ],
            'Modify sticker' => [
                'method' => 'modify',
                'args' => ['::guild id::', '::sticker id::', new ModifyStickerBuilder()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Sticker::class,
                    'array' => true,
                ]
            ],
            'Delete sticker' => [
                'method' => 'delete',
                'args' => ['::guild id::', '::sticker id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
        ];
    }
}
