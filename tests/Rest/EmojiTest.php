<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Emoji as PartsEmoji;
use Ragnarok\Fenrir\Rest\Emoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\CreateEmojiBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class EmojiTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Emoji::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'List guild emojis' => [
                'method' => 'listGuildEmojis',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                    'array' => true,
                ]
            ],
            'Get guild emoji' => [
                'method' => 'getGuildEmoji',
                'args' => ['::guild id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Create guild emoji' => [
                'method' => 'createGuildEmoji',
                'args' => ['::guild id::', new CreateEmojiBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Modify guild emoji' => [
                'method' => 'modifyGuildEmoji',
                'args' => ['::guild id::', '::emoji id::', new CreateEmojiBuilder()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Delete guild emoji' => [
                'method' => 'deleteGuildEmoji',
                'args' => ['::guild id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],

            'List application emojis' => [
                'method' => 'listApplicationEmojis',
                'args' => ['::application id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                    'array' => true,
                ]
            ],
            'Get application emoji' => [
                'method' => 'getApplicationEmoji',
                'args' => ['::application id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Create application emoji' => [
                'method' => 'createApplicationEmoji',
                'args' => ['::application id::', new CreateEmojiBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Modify application emoji' => [
                'method' => 'modifyApplicationEmoji',
                'args' => ['::application id::', '::emoji id::', new CreateEmojiBuilder()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Delete application emoji' => [
                'method' => 'deleteApplicationEmoji',
                'args' => ['::application id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
        ];
    }
}
