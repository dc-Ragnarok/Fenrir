<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\StickerPack;
use Ragnarok\Fenrir\Parts\Sticker;
use Ragnarok\Fenrir\Rest\GuildSticker;
use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\ModifyStickerBuilder;
use Ragnarok\Fenrir\Rest\Helpers\GuildSticker\StickerBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class GuildStickerTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GuildSticker::class;

    public static function httpBindingsProvider(): array
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
